<?php
// include 'config/db.php';
$uploadDir = 'uploads/';
$response = array(
    'status' => 'error',
    'message' => 'Form submission failed, please try again.'
);

if (isset($_POST)) {
    if (!empty($_POST['modelname']) && !empty($_POST['serialnumber'] && !empty($_POST['fiscalCheck']))) {
        $model = $_POST['modelname'];
        $serialnumber = $_POST['serialnumber'];
        $fiscalCheck = $_POST['fiscalCheck'];
        // $find = $db->query('SELECT * FROM sendform WHERE modelname LIKE' . $model . ' AND serialnumber LIKE' . $serialnumber . ' AND fiscalCheck LIKE' . $fiscalCheck);
        $find = false;

        if ($find) {
            $response['message'] = 'Такі дані вже існують';
            echo json_encode($response);
        } else {

            if (!empty($_POST['useremail'])) {
                $address = $_POST['useremail'];
            }

            if (!empty($_POST['firstname'])) {
                $name = $_POST['firstname'];
            }

            if (!empty($_POST['lastname'])) {
                $lastname = $_POST['lastname'];
            }

            if (!empty($_POST['userphone'])) {
                $phone = $_POST['userphone'];
            }

            if (!empty($_POST['area'])) {
                $area = $_POST['area'];
            }
            if (!empty($_POST['city'])) {
                $city = $_POST['city'];
            }

            if (!empty($_POST['index'])) {
                $index = $_POST['index'];
            }
            if (!empty($_POST['department'])) {
                $department = $_POST['department'];
            }
            if (isset($area, $city, $index)) {
                $location = '';
                $location .= "<p><strong>Область: </strong></p>" . $area;
                $location .= "<p><strong>Місто/населений пункт: </strong></p>" . $city;
                $location .= "<p><strong>Індекс: </strong></p>" . $index;
            }
            if (!empty($_POST['instrument'])) {
                $instrument = '<p><strong>Прилад </strong></p>' . $_POST['instrument'];
            }
            if (!empty($_POST['brand'])) {
                $brand = $_POST['brand'];
                $instrument .= '<p><strong>Бренд </strong></p>' . $brand;
            }
            if (!empty($_POST['modelname'])) {
                $model = $_POST['modelname'];
                $instrument .= '<p><strong>Назва моделі </strong></p>' . $model;
            }
            if (!empty($_POST['purchasedate'])) {
                $date = $_POST['purchasedate'];
            }
            if (!empty($_POST['nc12'])) {
                $nc12 = $_POST['nc12'];
            }
            if (!empty($_POST['serialnumber'])) {
                $serialnumber = $_POST['serialnumber'];
            }
            if (!empty($_POST['fiscalCheck'])) {
                $fiscalCheck = $_POST['fiscalCheck'];
            }
            if (!empty($_POST['shopname'])) {
                $shopname = $_POST['shopname'];
            }
            if (!empty($_POST['cost'])) {
                $cost = $_POST['cost'];
            }



//Content
                        
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: webmaster@example.com' . "\r\n";
            $headers .= 'Reply-To: webmaster@example.com' . "\r\n";
            // $headers .= 'X-Mailer: PHP/' . phpversion();
            //$to = $address;
            $to = 'soloveyalexey3@gmail.com';
            $subject = 'Заявка на реэстрацію приладу';
//            include "mail.php";
            $message = '<b>Ваша заявка прийнята</b> ' . "\r\n" . ' ми з вами зв"яжемося';

            if (mail($to, $subject, $message, $headers)) {
                // echo 'Лист замовнику відправлено вдало';
                $response['status'] = 'success';
                $response['message'] = 'Дані у базу даних додано успішно';
            } else {
                $response['message'] = 'Помилка відправки';
                echo json_encode($response);
            };

            $bound="filename-".rand(1000,99999);
            $headers = "Content-Type: multipart/mixed; boundary=\"$bound\"\n";
            $headers .= 'From: webmaster@example.com';
            $headers .= 'Reply-To: webmaster@example.com';
            $headers .= 'X-Mailer: PHP/' . phpversion();


            $boundary = "--" . md5(uniqid(time()));
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";


            // $to = $address;
            $to = 'soloveyalexey3@gmail.com';
            $subject = 'Заявка на реэстрацію приладу';


            $message = "<html>
            <head>
              <title>Інформація замовника</title>
            </head>
            <body>
              <h1> Вам подано заявку</h1>
              <p><h2>Інформація замовника</h2></p>
              <table border=\"1\" cellpadding=\"5\" width=\"700\">
                <tr>
                  <td>Ім'я</td><td>" . $name . ' ' . $lastname . "</td>
                </tr>
                <tr>
                  <td>Телефон</td><td>" . $phone . "</td>
                </tr>
                <tr>
                   <td>Електронна пошта</td><td>" . $address . "</td>
                </tr>
                <tr>
                   <td>Адресса</td><td>" . $location . "</td>
                </tr>
                 <tr>
                   <td>Інформація про прилад</td><td>" . $instrument . "</td>
                </tr>
                <tr>
                   <td>Код 12nc (комерційний код)</td><td>" . $nc12 . "</td>
                </tr>
                <tr>
                   <td>Серійний номер</td><td>" . $serialnumber . "</td>
                </tr>
                <tr>
                   <td>Дата придбання</td><td>" . $date . "</td>
                </tr>
                <tr>
                   <td>Номер фіксального чеку</td><td>" . $fiscalCheck . "</td>
                </tr>";

            if(!empty($cost)) {
                $message .= "<tr>
                        <td>Вартість приладу</td><td>" . $cost . "</td>
                    </tr>";
            }   
            $message .=    "<tr>
                   <td>Назва магазину</td><td>" . $shopname . "</td>
                </tr>
                <tr>
                   <td>Згода отрымуваты повідомлення</td><td>" . " " . "</td>
                </tr>
              </table>
            </body>
            </html>";


            if (!empty($_FILES['photodownload'])) {

                if (!empty($_FILES["photodownload"]["name"])) {                   
                    // File path config
                    $fileName = basename($_FILES["photodownload"]["name"]);
                    $fileNameNoExtension = preg_replace("/\.[^.]+$/", "", $fileName);

                    $targetFilePath = $uploadDir . $fileName;

                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    
                    $newFileNamePath = $uploadDir . $fileNameNoExtension . md5(uniqid(time())) . '.' . $fileType;

                    // Allow certain file formats
                    $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');

                    if (in_array($fileType, $allowTypes)) {
                        // Upload file to the server
                        if (move_uploaded_file($_FILES["photodownload"]["tmp_name"], $newFileNamePath)) {
                            $uploadedFile = $fileName;
                            $uploadStatus = 1;

                        } else {
                            $uploadStatus = 0;
                            $response['message'] = 'Sorry, there was an error uploading your file.';
                            echo json_encode($response);
                        }
                    } else {
                        $uploadStatus = 0;
                        $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                        echo json_encode($response);
                    }
                }
                if (!empty($_FILES['photodownload2'])) {
                    if (!empty($_FILES["photodownload2"]["name"])) {                   
                        // File path config
                        $fileName2 = basename($_FILES["photodownload2"]["name"]);
                        $fileNameNoExtension = preg_replace("/\.[^.]+$/", "", $fileName2);

                        $targetFilePath = $uploadDir . $fileName2;

                        $fileType2 = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        
                        $newFileNamePath2 = $uploadDir . $fileNameNoExtension . md5(uniqid(time())) . '.' . $fileType2;

                        // Allow certain file formats
                        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');

                        if (in_array($fileType, $allowTypes)) {
                            // Upload file to the server
                            if (move_uploaded_file($_FILES["photodownload2"]["tmp_name"], $newFileNamePath2)) {
                                $uploadedFile2 = $fileName2;
                                $uploadStatus = 2;

                            } else {
                                $uploadStatus = 0;
                                $response['message'] = 'Sorry, there was an error uploading your file.';
                                echo json_encode($response);
                            }
                        } else {
                            $uploadStatus = 0;
                            $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                            echo json_encode($response);
                        }
                    }
                }



                if ($uploadStatus >= 1) {

                    function readFileFn($filePath){
                        $fp = fopen($filePath, "r");
                        if (!$fp) {
                            print "Файл $filePath не может быть прочитан";
                            exit();
                        }
                        $file = fread($fp, filesize($filePath));
                        fclose($fp);
                        return $file;
                    }
                    $file = readFileFn($newFileNamePath);

                    if($uploadStatus == 2) {
                        $file2 = readFileFn($newFileNamePath2);
                    }

                    
                    $body = "--$boundary\n";
                    /* Присоединяем текстовое сообщение */
                    $body .= "Content-type: text/html; charset='utf-8'\n";
                    $body .= "Content-Transfer-Encoding: quoted-printablenn";
                    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode('чек.'.$fileType)."?=\n\n";
                    $body .= $message."\n";
                    $body .= "--$boundary\n";

                    $body .= "\r\n--$boundary\r\n"; 
                    $body .= "Content-Type: application/octet-stream; name=\"чек.$fileType\"\r\n";  
                    $body .= "Content-Transfer-Encoding: base64\r\n"; 
                    $body .= "Content-Disposition: attachment; filename=\"чек.$fileType\"\r\n";
                    $body .= "\r\n";
                    $body .= chunk_split(base64_encode($file));
                    $body .= "\r\n--$boundary\r\n";

                    $body .= "Content-Type: application/octet-stream; name=\"облікова_картка.$fileType2\"\r\n";  
                    $body .= "Content-Transfer-Encoding: base64\r\n"; 
                    $body .= "Content-Disposition: attachment; filename=\"облікова_картка.$fileType2\"\r\n";
                    $body .= "\r\n";
                    $body .= chunk_split(base64_encode($file2));
                    $body .= "\r\n--$boundary\r\n";

                    // Insert form data in the database
                    // $insert = $db->query("INSERT INTO sendform (firstname,lastname,userphone,useremail,area,city,index,department,instrument,brand,modelname,nc12,serialnumber,purchasedate,fiscalCheck,shopname,photodownload) VALUES ('" . $name . "','" . $lastname . "','" . $phone . "','" . $address . "','" . $area . "','" . $city . "','" . $index . "','" . $department . "','" . $_POST['instrument'] . "','" . $_POST['brand'] . "','" . $_POST['modelname'] . "','" . $nc12 . "','" . $serialnumber . "','" . $date . "','" . $fiscalCheck . "','" . $shopname . "','" . $uploadedFile . "')");
                    // var_dump($insert);
                    $insert = false;
                    if ($insert) {
                        $response['status'] = 'success';
                        $response['message'] = 'Дані у базу даних додано успішно';
                    }

                } else {
                    $body = $message;
                }


            }

            if (mail($to, $subject, $body, $headers)) {
                $response['status'] = 'success';
                $response['message'] = 'Листи реєстрації та данні кліэнта відправлено вдало';
                echo json_encode($response);

            } else {
                $response['message'] = 'Помилка відправки';
                echo json_encode($response);
            }
        }
    }
}

