<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendEmailWithYandex($name, $phone, $message) {
    $mail = new PHPMailer(true);
    $debug_output = '';
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'darthmarketing@yandex.ru';
        $mail->Password = 'ohxgtwwsicrptila';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->SMTPDebug = 2;
        
        $mail->Debugoutput = function($str, $level) use (&$debug_output) {
            $debug_output .= "SMTP Debug ($level): $str\n";
        };
        
        $mail->setFrom('darthmarketing@yandex.ru', 'Сайт kataem-zimoi.space');
        $mail->addAddress('darthmarketing@yandex.ru');
        
        $mail->isHTML(false);
        $mail->Subject = 'Заявка с сайта kataem-zimoi.space';
        
        $body = "Имя: $name\n";
        $body .= "Телефон: $phone\n";
        $body .= "Сообщение: $message\n";
        $body .= "\nОтправлено: " . date('d.m.Y H:i:s') . "\n";
        
        $mail->Body = $body;
        
        if ($mail->send()) {
            return ['success' => true, 'message' => 'Сообщение успешно отправлено!', 'debug' => $debug_output];
        } else {
            throw new Exception("Сообщение не отправлено: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        $error_message = 'Ошибка при отправке через SMTP: ' . $e->getMessage();
        $debug_output .= "\n" . $error_message . "\n";
        
        return ['success' => false, 'message' => $error_message, 'debug' => $debug_output];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? 'Не указано';
    $phone = $_POST['phone'] ?? 'Не указано';
    $message = $_POST['message'] ?? 'Не указано';
    
    $result = sendEmailWithYandex($name, $phone, $message);
    
    $mail_sent = $result['success'];
    $result_message = $result['message'];
    $debug_info = $result['debug'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Форма обратной связи</title>
</head>

<body>
    <?php if (isset($result_message)): ?>
    <div>
        <?php echo $mail_sent ? 'Отправлено: ' : 'Неотправлено: '; ?><?php echo $result_message; ?>
    </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <input type="text" name="name" id="name" placeholder="Имя" required>
        </div>
        <div>
            <input type="text" name="phone" id="phone" placeholder="Телефон" required>
        </div>
        <div>
            <textarea name="message" id="message" placeholder="Что требуется" rows="5"></textarea>
        </div>
        <div>
            <button type="submit">Отправить</button>
        </div>
    </form>
</body>

</html>