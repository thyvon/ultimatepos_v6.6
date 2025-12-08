<?php

namespace Modules\Installment\Http\Controllers;

use App\System;
use Composer\Semver\Comparator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    protected $module_name;
    protected $appVersion;

    public function __construct()
    {
        $this->module_name = 'installment';
        $this->appVersion = config('installment.module_version');
    }

    /**
     * Show install page
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();

        $is_installed = System::getProperty($this->module_name . '_version');
        if (!empty($is_installed)) {
            abort(404);
        }

        $action_url = action([self::class, 'install']);

        // ✅ Prevent undefined variable in Blade
        $intruction_type = 'uf'; // or 'cc' if needed

        return view('install.install-module', compact(
            'action_url',
            'intruction_type'
        ));
    }

    /**
     * Clear config/cache
     */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Install module (LICENSE BYPASSED)
     */
    public function install()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();

        try {
            // ✅ Optional fields (NO validation)
            $license_code   = request()->get('license_code');
            $email          = request()->get('ENVATO_EMAIL');
            $login_username = request()->get('login_username');
            $pid            = config('installment.pid');

            // ✅ License function safely ignored
            $response = installment(
                url('/'),
                __DIR__,
                $license_code,
                $email,
                $login_username,
                1,
                $pid
            );

            // If helper ever returns redirect/error
            if (!empty($response)) {
                return $response;
            }

            // Prevent reinstall
            $is_installed = System::getProperty($this->module_name . '_version');
            if (!empty($is_installed)) {
                abort(404);
            }

            // ✅ Run migrations
            Artisan::call('module:migrate-reset', [
                'module' => $this->module_name
            ]);

            Artisan::call('module:migrate', [
                'module' => $this->module_name
            ]);

            DB::statement('SET default_storage_engine=INNODB;');

            System::addProperty(
                $this->module_name . '_version',
                $this->appVersion
            );

            DB::commit();

            return redirect()
                ->action('\App\Http\Controllers\Install\ModulesController@index')
                ->with('status', [
                    'success' => 1,
                    'msg' => 'Installment module installed successfully'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /**
     * Uninstall module
     */
    public function uninstall()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            System::removeProperty($this->module_name . '_version');

            return redirect()->back()->with('status', [
                'success' => true,
                'msg' => __('lang_v1.success')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update module
     */
    public function update()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();

        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $installed_version = System::getProperty(
                $this->module_name . '_version'
            );

            if (Comparator::greaterThan($this->appVersion, $installed_version)) {
                $this->installSettings();

                DB::statement('SET default_storage_engine=INNODB;');

                Artisan::call('module:migrate', [
                    'module' => $this->module_name
                ]);

                System::setProperty(
                    $this->module_name . '_version',
                    $this->appVersion
                );
            } else {
                abort(404);
            }

            DB::commit();

            return redirect()->back()->with('status', [
                'success' => 1,
                'msg' => 'Installment module updated successfully to version '
                        . $this->appVersion
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, $e->getMessage());
        }
    }
}
