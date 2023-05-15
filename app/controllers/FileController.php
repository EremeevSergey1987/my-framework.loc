<?php
namespace app\controllers;
use RedBeanPHP\R;
use wfm\Controller;
use app\models\File;

/**
 * @property File $model
 */
class FileController extends Controller
{
    public $user_id;
    public function indexAction()
    {
        $this->user_id = $_SESSION['user']['id'];
        $files_one_user = R::getAll( "SELECT * FROM files WHERE main_user = {$this->user_id}" );
        $this->setMeta('Files', 'Files', 'Files');
        $this->set(compact('files_one_user'));
    }

    public function dellAction()
    {
        $id = $_GET['id'];
        $this->user_id = $_SESSION['user']['id'];
        $files_name = R::load('files', $id);
        $this->model->dell_file($id, $this->user_id, $files_name->file_name);
        $this->redirect('/file');
        $this->setMeta('Регистрация!!!', 'Регистрация', 'Регистрация');

    }

    public function addAction(){
        $this->setMeta('Files', 'Files', 'Files');

        $input_name = 'image';

// Разрешенные расширения файлов.
        $allow = array();

// Запрещенные расширения файлов.
        $deny = array(
            'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp',
            'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html',
            'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi'
        );

        // Директория пользователя, куда будут загружаться файлы.
        $path = FILE_DIRECTORY . $_SESSION['user']['id'] . "/";


        if (isset($_FILES['image'])) {
            // Проверим директорию для загрузки.
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            // Преобразуем массив $_FILES в удобный вид для перебора в foreach.
            $files = array();
            $diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);


            if ($diff == 0) {
                $files = array($_FILES[$input_name]);
            } else {
                foreach($_FILES[$input_name] as $k => $l) {
                    foreach($l as $i => $v) {
                        $files[$i][$k] = $v;
                    }
                }
            }

            foreach ($files as $file) {
                $error = $success = '';

                // Проверим на ошибки загрузки.
                if (!empty($file['error']) || empty($file['tmp_name'])) {
                    switch (@$file['error']) {
                        case 1:
                        case 2: $_SESSION['errors'] = 'Превышен размер загружаемого файла.'; break;
                        case 3: $_SESSION['errors'] = 'Файл был получен только частично.'; break;
                        case 4: $_SESSION['errors'] = 'Файл не был загружен.'; break;
                        case 6: $_SESSION['errors'] = 'Файл не загружен - отсутствует временная директория.'; break;
                        case 7: $_SESSION['errors'] = 'Не удалось записать файл на диск.'; break;
                        case 8: $_SESSION['errors'] = 'PHP-расширение остановило загрузку файла.'; break;
                        case 9: $_SESSION['errors'] = 'Файл не был загружен - директория не существует.'; break;
                        case 10: $_SESSION['errors'] = 'Превышен максимально допустимый размер файла.'; break;
                        case 11: $_SESSION['errors'] = 'Данный тип файла запрещен.'; break;
                        case 12: $_SESSION['errors'] = 'Ошибка при копировании файла.'; break;
                        default: $_SESSION['errors'] = 'Файл не был загружен - неизвестная ошибка.'; break;
                    }
                } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
                    $error = 'Не удалось загрузить файл.';
                } else {
                    // Оставляем в имени файла только буквы, цифры и некоторые символы.
                    $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
                    $name = mb_eregi_replace($pattern, '-', $file['name']);
                    $name = mb_ereg_replace('[-]+', '-', $name);
                    $name = $file['name'];


                    // Т.к. есть проблема с кириллицей в названиях файлов (файлы становятся недоступны).
                    // Сделаем их транслит:
                    $converter = array(
                        'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',   'е' => 'e',
                        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',    'и' => 'i',   'й' => 'y',   'к' => 'k',
                        'л' => 'l',   'м' => 'm',   'н' => 'n',    'о' => 'o',   'п' => 'p',   'р' => 'r',
                        'с' => 's',   'т' => 't',   'у' => 'u',    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',  'ь' => '',    'ы' => 'y',   'ъ' => '',
                        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

                        'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                        'Л' => 'L',   'М' => 'M',   'Н' => 'N',    'О' => 'O',   'П' => 'P',   'Р' => 'R',
                        'С' => 'S',   'Т' => 'T',   'У' => 'U',    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',  'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
                        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
                    );

                    $name = strtr($name, $converter);
                    $parts = pathinfo($name);

                    if (empty($name) || empty($parts['extension'])) {
                        $_SESSION['errors'] = 'Недопустимое тип файла';
                    } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
                        $_SESSION['errors'] = 'Недопустимый тип файла';
                    } elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
                        $_SESSION['errors'] = 'Недопустимый тип файла';
                    } else {
                        // Чтобы не затереть файл с таким же названием, добавим префикс.
                        $i = 0;
                        $prefix = '';
                        while (is_file($path . $parts['filename'] . $prefix . '.' . $parts['extension'])) {
                            $prefix = '(' . ++$i . ')';
                        }
                        $name = $parts['filename'] . $prefix . '.' . $parts['extension'];

                        // Перемещаем файл в директорию.
                        if (move_uploaded_file($file['tmp_name'], $path . $name)) {
                            // Далее можно сохранить название файла в БД и т.п.
                            $user_id = $_SESSION['user']['id'];
                            $files_user = R::exec( "INSERT INTO files  (file_name, main_user, size_file, additional_users) VALUES ('{$name}', {$user_id}, {$file['size']}, '0'); " );
                            $_SESSION['success'] = 'Файл «' . $name . '» успешно загружен.';
                        } else {
                            $_SESSION['errors'] = 'Не удалось загрузить файл.';
                        }
                    }
                }
                $this->redirect('/file');
            }
        }
    }


}