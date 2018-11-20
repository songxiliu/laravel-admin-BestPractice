<?php

namespace App\Http\Middleware;

use Closure;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;

class DataAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$model)
    {
        $path = $request->path();
        if(preg_match('/admin\/'.strtolower($model).'\/(\d+)\/edit/',$path) > 0 ||
            preg_match('/admin\/'.strtolower($model).'\/(\d+)/',$path) > 0){

            if(preg_match('(\d+)',$path,$result) > 0){
                if(is_array($result)&&!empty($result)&&!empty($result[0])){
                    $id =  $result[0];
                    $admin_ids = DB::select('select admin_id from '.$model.' where id = ?', [$id]);
                    if(is_array($admin_ids)&&!empty($admin_ids)&&!empty($admin_ids[0])){
                        $admin_id = $admin_ids[0]->admin_id;
                        $admin_user = Admin::user();
                        if($admin_id != $admin_user->id &&
                            !$admin_user->isRole('datamanager')){
                            return redirect()->to('admin/deny');
                        }
                    }
                }
            }
        }
        return $next($request);


    }
}
