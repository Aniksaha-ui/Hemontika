<?php

namespace App\Repositories;

use App\Enums\ImagePaths;
use Illuminate\Support\Facades\Storage;

use Image;

use File;

use Illuminate\Support\Facades\Auth;

class PictureUploadRepository
{
    public function pictureUploadWithOutThumb($file, $folderPath, $mainHeight = false, $mainWidth = false, $imageName, $ratio = false)
    {

        $mainFile = $file;
        if (!File::exists(public_path($folderPath))) {
            File::makeDirectory(public_path() . '/' . $folderPath, 0777, true, true);
        }

        if ($ratio && $mainHeight && $mainWidth) {
            $canvas = Image::canvas($mainWidth, $mainHeight, '#F5F5F5');

            $image = Image::make($mainFile->getRealPath())->resize($mainWidth, $mainHeight, function ($constraint) {
                $constraint->aspectRatio();
            });

            $canvas->insert($image, 'center');
            $canvas->save(public_path($folderPath . '/' . $imageName . '.png'));
        } elseif ($mainHeight && $mainWidth) {
            Image::make($mainFile)->resize($mainWidth, $mainHeight)->save(public_path($folderPath . '/' . $imageName . '.png'));
        } else {
            Image::make($mainFile)->save(public_path($folderPath . '/' . $imageName . '.png'));
        }



        return [
            'full_name' => $imageName . '.png',
        ];

    }

    public function pictureUploadWithThumb($file, $mainHeight = false, $mainWidth = false, $thumbHeight = 230, $thumbWidth = 370, $imageName)
    {
        try {
            $folderPath = 'uploads';
            $mainFile = $file;
            // dd(public_path());
            if (!File::exists(public_path($folderPath))) {
                File::makeDirectory(public_path() . $folderPath, 0777, true, true);
            }

            Storage::disk('local')->delete($imageName . ".png");
            Storage::disk('local')->delete($imageName . "_thumb.png");

//        main file saving
            if ($mainHeight && $mainWidth) {
                $mianphoto = Image::make($mainFile)->resize($mainWidth, $mainHeight)->encode('png');
            } else {
                $mianphoto = Image::make($mainFile)->encode('png');
            }

//        thumb file saving


            $thumbphoto = Image::make($mainFile)
                ->resize($thumbWidth, $thumbHeight, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('jpg');
            Storage::disk('local')->put($imageName . ".png", $mianphoto);
            Storage::disk('local')->put($imageName . "_thumb.png", $thumbphoto);
            return [
                'full_name' => $imageName . '.png',
                'thumb_name' => $imageName . '_thumb.png',
            ];
        } catch (\Exception $e) {
            dd($e);
        }


    }

    public function prescriptionPictureUpload($file, $imageName)
    {
        try {
            $folderPath = 'uploads/';
            $mainFile = $file;
            // dd(public_path());
            if (!File::exists(public_path($folderPath))) {
                File::makeDirectory(public_path() . $folderPath, 0777, true, true);
            }

            Storage::disk('local')->delete($imageName . ".jpg");

//        main file saving
            $file->move($folderPath, $imageName . ".jpg");
            // $mianphoto = Image::make($mainFile);
            // $mianphoto->heighten(650)
            //           ->encode('jpg', 100);
            

            // Storage::disk('local')->put($imageName . ".jpg", $mianphoto);  
            return [
                'full_name' => $imageName . '.jpg'
            ];
        } catch (\Exception $e) {
            return ['error' => true];
        }


    }


}