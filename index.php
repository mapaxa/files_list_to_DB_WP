<?php 

/*прога для переведения файлов в списке в массив для передачи в БД Wordpress */
define('WORK_FOLDER', $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']);
//echo WORK_FOLDER;
$path_to_input = WORK_FOLDER . 'input/';
$file_towrite_in = WORK_FOLDER . 'query.txt';

$files_list = scandir($path_to_input);
$files_list = array_diff($files_list, array('.', '..'));


$id_arr = array();
for($i = 2877, $j = 232350 ; $i <= 2978, $j <= 232451 ; $i++, $j++){
	$id_arr[$i] = $j;
}
var_dump($id_arr);

//удалить точки папок возврата
foreach ($files_list as $key => $file) {

	//echo $path_to_input.$file . '<br>';
	//читаем каждый файл
	$handle = fopen($path_to_input.$file, 'r');

	$lines_value = fread($handle, filesize($path_to_input.$file));
	$array_with_file_data = explode("\r\n", $lines_value);
	$array_with_file_data[3] = mb_convert_encoding($array_with_file_data[3], "UTF-8", "WINDOWS-1251");

	//var_dump($array_with_file_data);
	//вырезаем лишнее из файла, чтобы только идентификатор остался
	$file_index = substr($file, 1);
	$file_index = stristr($file_index, '-',true);

	//сравниваем имена файлов с созданным массивом ID => user_nicename
	$db_user_id = array_search($file_index, $id_arr);
	echo $file_index . '   ' .$db_user_id .'<br>';


	//var_dump($new_array);
	fclose($handle);


		$f = fopen($file_towrite_in, 'a');
		/*fwrite($f, '(');
		fwrite($f, $db_user_id.', ');//id
		fwrite($f, $array_with_file_data[2].', ');//first_name
		fwrite($f, $array_with_file_data[3].', ');//fio
		fwrite($f, $array_with_file_data[0].', ');//agreement_number
		fwrite($f, $array_with_file_data[13].', ');//email
		fwrite($f, 'undefined, undefined');
		fwrite($f, '),'."\r\n");
		fclose($f);*/


		fwrite($f, '(');
		fwrite($f, $db_user_id.', ');//id
		fwrite($f, 'first_name'.', ');// КЛЮЧ МЕТА ПОЛЯ
		fwrite($f, $array_with_file_data[2]);//first_name
		/*fwrite($f, $array_with_file_data[3]);//fio*/
		/*fwrite($f, $array_with_file_data[0]);//agreement_number*/
		/*fwrite($f, $array_with_file_data[13].', ');//email*/
		/*fwrite($f, 'undefined');*/
		fwrite($f, '),'."\r\n");
		fclose($f);



}
	//phpinfo();
	//var_dump($files_list);




