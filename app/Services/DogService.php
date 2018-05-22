<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25
 * Time: 14:04
 */

namespace App\Services;


use App\Dog;
use App\DogFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DogService
{
    public static function publish(array $data)
    {
        // 价格
        DB::beginTransaction();
        try {
            $dog = new Dog();
            $files = $data ['files'];
            $dog_info = $data['dog_info'];
            unset($data['dog_info']);
            unset($data['files']);
            $data ['user_id'] = Auth::id();
            $save = $dog->fill($data)->save();
            if ($save) {
                $thumb = '';
                if (!empty($files)) {
                    $c = [];
                    foreach ($files as $file) {
                        $c [] = new DogFile(['url' => $file ['url'], 'type' => $file ['type']]);
                    }
                    // 提取第一张图片为缩略图
                    $thumb = $files[0]['url'];
                }
                $save = $dog->files()->saveMany($c);

                $dogInfoSave = $dog->dogInfo()->create(
                    [
                        'thumb' => $thumb,
                        'detail' => $dog_info['detail']
                    ]);
                if ($save && $dogInfoSave) {
                    DB::commit();
                    return $dog;
                }
            }
            DB::rollBack();
            return false;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }


    // @todo 需要优化
    public static function update(array $data)
    {
        // 价格
        DB::beginTransaction();
        try {
            $dog = Dog::find($data['id']);
            $files = $data ['files'];
            $dog_info = $data['dog_info'];
            unset($data['dog_info']);
            unset($data['files']);
            $save = $dog->fill($data)->save();
            if ($save) {
                $thumb = '';
                if (!empty($files)) {
                    $c = [];
                    foreach ($files as $file) {
                        $c [] = new DogFile(['url' => $file ['url'], 'type' => $file ['type']]);
                    }
                    // 提取第一张图片为缩略图
                    $thumb = $files[0]['url'];
                }
                $dog->files()->delete();
                $save = $dog->files()->saveMany($c);

                $dogInfoSave = $dog->dogInfo()->first()->fill(
                    [
                        'thumb' => $thumb,
                        'detail' => $dog_info['detail']
                    ])->save();
                if ($save && $dogInfoSave) {
                    DB::commit();
                    return $dog;
                }
            }
            DB::rollBack();
            return false;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
