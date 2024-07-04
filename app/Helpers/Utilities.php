<?php 
if (!function_exists('sidebar_open')) {
    function sidebar_open($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'active' : '';
    }
}

if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'categories', $filename)
    {
        if (!empty($imageUrl)) {
                                                    
            //save 60x60 image
            \Storage::disk('public')->makeDirectory($type.'/small');
            $path60X60     = storage_path('app/public/'.$type.'/small/'.$filename);
            //$canvas = \Image::canvas(60, 60);
            $image = \Image::make($imageUrl)->resize(null, 60,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });
            //$canvas->insert($image, 'center');
            $image->save($path60X60, 70); 
            
            //save 350X350 image
            \Storage::disk('public')->makeDirectory($type.'/medium');
            $path350X350     = storage_path('app/public/'.$type.'/medium/'.$filename);
            //$canvas = \Image::canvas(350, 350);        
            $image = \Image::make($imageUrl)->resize(null, 350,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });
            //$canvas->insert($image, 'center');
            $image->save($path350X350, 75);

            return $filename;
        } else { return false; }
    }
}