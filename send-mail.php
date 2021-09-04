<?php
// include 'config/db.php';
$uploadDir = 'uploads/';
$response = array(
    'status' => 0,
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
        } else {
            $bound="filename-".rand(1000,99999);
            $headers = "Content-Type: multipart/mixed; boundary=\"$bound\"\n";
            $headers .= 'From: webmaster@example.com';
            $headers .= 'Reply-To: webmaster@example.com';
            $headers .= 'X-Mailer: PHP/' . phpversion();

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


//Content
            //$to = $address;
            $to = 'soloveyalexey3@gmail.com';
            $subject = 'Заявка на реэстрацію приладу';
            $message = 'Ваша заявка прийнята ' . "\r\n" . ' ми з вами зв"яжемося';

            if (mail($to, $subject, $message, $headers)) {
                // echo 'Лист замовнику відправлено вдало';
            } else {
                echo 'Помилка відправки';
            };


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
              <table border=\"1\" cellpadding=\"5\" align=\"left\">
                <tr>
                  <th>Ім'я</th><td>" . $name . ' ' . $lastname . "</td>
                </tr>
                <tr>
                  <th>Телефон</th><td>" . $phone . "</td>
                </tr>
                <tr>
                   <th>Електронна пошта</th><td>" . $address . "</td>
                </tr>
                <tr>
                   <th>Адресса</th><td>" . $location . "</td>
                </tr>
                 <tr>
                   <th>Інформація про прилад</th><td>" . $instrument . "</td>
                </tr>
                <tr>
                   <th>Код 12nc (комерційний код)</th><td>" . $nc12 . "</td>
                </tr>
                <tr>
                   <th>Серійний номер</th><td>" . $serialnumber . "</td>
                </tr>
                <tr>
                   <th>Дата придбання</th><td>" . $date . "</td>
                </tr>
            <tr>
                   <th>Номер фіксального чеку</th><td>" . $fiscalCheck . "</td>
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
                        }
                    } else {
                        $uploadStatus = 0;
                        $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                    }
                }

                if ($uploadStatus == 1) {

                    $fp = fopen($targetFilePath, "r");

                    if (!$fp) {
                        print "Файл $uploadedFile не может быть прочитан";
                        exit();
                    }

                    $file = fread($fp, filesize($targetFilePath));

                    // echo $targetFilePath;
                    fclose($fp);

                    echo $fileName;
                    $fileName2 = "some2.jpg";

                    
                    $body = "--$boundary\n";
                    /* Присоединяем текстовое сообщение */
                    $body .= "Content-type: text/html; charset='utf-8'\n";
                    $body .= "Content-Transfer-Encoding: quoted-printablenn";
                    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode('чек.'.$fileType)."?=\n\n";
                    $body .= $message."\n";
                    $body .= "--$boundary\n";

                    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode('чек.'.$fileType)."?=\n";
                    $body .= "Content-Transfer-Encoding: base64\n";
                    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode('чек.'.$fileType)."?=\n\n";
                    $body .= chunk_split(base64_encode($file))."\n";
                    $body .= "--".$boundary ."--\n";


                    // Insert form data in the database
                    // $insert = $db->query("INSERT INTO sendform (firstname,lastname,userphone,useremail,area,city,index,department,instrument,brand,modelname,nc12,serialnumber,purchasedate,fiscalCheck,shopname,photodownload) VALUES ('" . $name . "','" . $lastname . "','" . $phone . "','" . $address . "','" . $area . "','" . $city . "','" . $index . "','" . $department . "','" . $_POST['instrument'] . "','" . $_POST['brand'] . "','" . $_POST['modelname'] . "','" . $nc12 . "','" . $serialnumber . "','" . $date . "','" . $fiscalCheck . "','" . $shopname . "','" . $uploadedFile . "')");
                    // var_dump($insert);
                    $insert = false;
                    if ($insert) {
                        $response['status'] = 1;
                        $response['message'] = 'Дані у базу даних додано успішно';
                    }

                } else {
                    $body = $message;
                }


            }

            if (mail($to, $subject, $body, $headers)) {
                // echo 'Лист реєстрації відправлено вдало';

            } else {
                echo 'Помилка відправки';
            }
        }
    }
}

