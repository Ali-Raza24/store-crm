<?php

namespace App\Services;
use App\Constants\IStatus;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use \Intervention\Image\Facades\Image as ImageManager;

class ImageService
{
    public function save($request, $id, $image_type,$thumb, $width = null, $height = null){
        $files = $request->images;
        if (!empty(end($files))){
            foreach ($files as $key => $file){
                $file_data = $file;
                $file_name = 'image_' . $id .'_'.$key.'_'. time() . '.png';
                $file_data = explode(';', $file_data);
                if (count($file_data) > 1){
                    $file_data = $file_data[1];
                }else{
                    $file_data = $file_data[0];
                }
                $file_data = explode(',', $file_data);
                if (count($file_data) > 1){
                    $file_data = $file_data[1];
                }else{
                    $file_data = $file_data[0];
                }
                if ($file_data != "") {

                    if ($width) {
                        $small = ImageManager::make(base64_decode($file_data));
                        $cord = $this->getCenter($small, $width, $height);
                        $small = $small->crop($width, $height, $cord['x1'], $cord['y1'])->encode('png');

                        $large = ImageManager::make(base64_decode($file_data));
                        $cord = $this->getCenter($large, $width, $height);
                        $large = $large->crop($width, $height, $cord['x1'], $cord['y1'])->encode('png');
                    } else {
                        $small = ImageManager::make(base64_decode($file_data))->encode('png');
                        $large = ImageManager::make(base64_decode($file_data))->encode('png');
                    }

                    \Storage::disk('s3')->put('/thumbs/'.$thumb.'/'.$file_name, $small);
                    \Storage::disk('s3')->put($thumb.'/'.$file_name, $large);

                    $image = new Image();
                    $image->imageable_id = $id;
                    $image->key = (is_string($key)) ? $key : 'default';
                    $image->imageable_type = $image_type;
                    $image->url = \Storage::disk('s3')->url($thumb.'/'.$file_name);
                    $image->thumbnail = \Storage::disk('s3')->url('/thumbs/'.$thumb.'/'.$file_name);
                    $image->title = $file_name;
                    $image->is_active = IStatus::ACTIVE;
                    $image->save();
                }
            }
        }
    }

    public function saveImage($request, $id, $image_type, $thumb, $width = false, $height = false){
        $files = $request->images;

        if (is_array($files) && !empty(end($files))){
            foreach ($files as $key => $file){

                $imageKey = isset($key) ? $key : 'default';

                $file_data = $file;

                if ($file_data != "") {
                    $extension = $file_data->getClientOriginalExtension();
                    $file_name = 'image_' . $id .'_'.$key.'_'. time() . '.'.$extension;


                    if ($extension != 'pdf') {
                        if ($width) {
                            $small = ImageManager::make($file);
                            $cord = $this->getCenter($small, $width, $height);
//                            $small = $small->crop($width, $height, $cord['x1'], $cord['y1'])->encode($extension);
                            $small = $small->fit($width, $height, function ($constraint){
                                $constraint->upsize();
                            }, 'center')->encode($extension);
                            $large = ImageManager::make($file);
                            $cord = $this->getCenter($large, $width, $height);
//                            $large = $large->crop($width, $height, $cord['x1'], $cord['y1'])->encode($extension);
                            $large = $large->fit($width, $height, function ($constraint){
                                $constraint->upsize();
                            },'center')->encode($extension);
                        } else {
                            $small = ImageManager::make($file)->encode($extension);
                            $large = ImageManager::make($file)->encode($extension);
                        }

                        \Storage::disk('s3')->put('/thumbs/'.$thumb.'/'.$file_name, $small);
                        \Storage::disk('s3')->put($thumb.'/'.$file_name, $large);
                    } else {
                        \Storage::disk('s3')->put($thumb.'/'.$file_name, file_get_contents($file_data));
                    }

                    if (!in_array($key, ['logo', 'logo_mobile', 'profile'])) {
                        $image = new Image();
                        $image->imageable_id = $id;
                        $image->imageable_type = $image_type;
                        $image->key = $imageKey;
                        $image->url = \Storage::disk('s3')->url($thumb . '/' . $file_name);
                        $image->thumbnail = \Storage::disk('s3')->url('/thumbs/' . $thumb . '/' . $file_name);
                        $image->title = $file_name;
                        $image->is_active = IStatus::ACTIVE;
                        $image->save();
                    }
                }
            }
        }
    }

    public function saveImageObj($image, $key, $id, $image_type, $thumb, $width = false, $height = false){
        $file = $image;

        if ($file) {

            $imageKey = is_string($key) ? $key : 'default';

            $file_data = $file;

            if ($file_data != "") {
                $extension = $file_data->getClientOriginalExtension();
                $file_name = 'image_' . $id .'_'.$key.'_'. time() . '.'.$extension;

                if ($width) {
                    $small = ImageManager::make($file);
                    $cord = $this->getCenter($small, $width, $height);
//                    $small = $small->crop($width, $height, $cord['x1'], $cord['y1'])->encode($extension);
                    $small = $small->resizeCanvas($width, $height, 'center', true)->encode($extension);

                    $large = ImageManager::make($file);
                    $cord = $this->getCenter($large, $width, $height);
//                    $large = $large->crop($width, $height, $cord['x1'], $cord['y1'])->encode($extension);
                    $large= $large->resizeCanvas($width, $height, 'center', true)->encode($extension);
                }else{
                    $small = ImageManager::make($file)->encode($extension);
                    $large = ImageManager::make($file)->encode($extension);
                }

                \Storage::disk('s3')->put('/thumbs/'.$thumb.'/'.$file_name, $small);
                \Storage::disk('s3')->put($thumb.'/'.$file_name, $large);

                if (!in_array($key, ['logo', 'logo_mobile', 'profile'])) {
                    $image = new Image();
                    $image->imageable_id = $id;
                    $image->imageable_type = $image_type;
                    $image->key = $imageKey;
                    $image->url = \Storage::disk('s3')->url($thumb . '/' . $file_name);
                    $image->thumbnail = \Storage::disk('s3')->url('/thumbs/' . $thumb . '/' . $file_name);
                    $image->title = $file_name;
                    $image->is_active = IStatus::ACTIVE;
                    $image->save();
                }

                return \Storage::disk('s3')->url($thumb . '/' . $file_name);
            }
        }
        return false;
    }

    public function getCenter($image, $cropWidth, $cropHeight)
    {
        $centreX = round($image->getWidth() / 2);
        $centreY = round($image->getHeight() / 2);

        $cropWidthHalf  = round($cropWidth / 2); // could hard-code this but I'm keeping it flexible
        $cropHeightHalf = round($cropHeight / 2);

        $x1 = max(0, $centreX - $cropWidthHalf);
        $y1 = max(0, $centreY - $cropHeightHalf);

        $x2 = min($image->getWidth(), $centreX + $cropWidthHalf);
        $y2 = min($image->getHeight(), $centreY + $cropHeightHalf);
        return ['x1' => $x1, 'x2' => $x2, 'y1' => $y1, 'y2' => $y2];
    }


    public function update($request, $id, $image_type){
        $files = $request->images;
        if (!empty(end($files))){
            foreach ($files as $key => $file){
                $file_data = $file;
                $file_name = 'image_' . $id .'_'.$key.'_'. time() . '.png';
                list($type, $file_data) = explode(';', $file_data);
                list(, $file_data) = explode(',', $file_data);
                if ($file_data != "") {
                    \Storage::disk('s3')->put($file_name, base64_decode($file_data));
                    $image = Image::find($id);
                    $image->imageable_id = $id;
                    $image->imageable_type = $image_type;
                    $image->url = env('AWS_BUCKET_URL').'/file_name/'.$file_name;
                    $image->title = $file_name;
                    $image->is_active = IStatus::ACTIVE;
                    $image->update();
                }
            }
        }
    }
}
