<?php 
 
$files = @$_FILES;
$FILE  = 'gallery-images.json';
$json  = @file_get_contents($FILE);
$json  = json_decode($json, 1);
if(!@$json['galleryImages']) {
	$json['galleryImages'] = [];
}
$checkImg = 0;
$res   = [
	'r' => 0,
	'response' => '',
	'newImages' => [],
	'text' => 'Неизветная ошибка',
];


if(sizeof($files)> 0) {

	$iter=0;
	foreach($files as $f) {

		$ext = array_reverse(explode('.', $f['name']));

		if(in_array($ext[0], ['json'])) {

			if(move_uploaded_file($f['tmp_name'], $FILE)) {

				$json  = file_get_contents($FILE);
				$json  = json_decode($json, 1);

				$res['newImages']['galleryImages'] = $json['galleryImages'];
			}
		} 

		if(in_array($ext[0], ['png', 'jpg', 'gif'])) {
			$checkImg = 1;
			$iter++;
			$file_name = 'gal-'.$iter.'-'.time().rand(1, 5555).'.'.$ext[0];

			//@file_put_contents('uploads/'.$file_name, $f['tmp_name']);

			$size  = getimagesize($f['tmp_name']);

			if(move_uploaded_file($f['tmp_name'], 'uploads/'.$file_name)) {
				

				$res['newImages']['galleryImages'][] = 
				$json['galleryImages'][] = [
					'url' => 'uploads/'.$file_name,
					'width' => $size[0],
					'height' => $size[1],
				];
			}
		}
		
	}

	if($checkImg == 1) {
		$json = json_encode($json);
		@file_put_contents($FILE, $json);
	}
	

	
	$res['r']        = 1;
	$res['response'] = $json;
	$res['text']     = 'Файлы загружены!';
}


echo json_encode($res);