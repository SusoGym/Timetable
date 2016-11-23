<?php namespace timetable;
    $errorCode = 500;
    $errorMessage = "Unknown";
    $backTarget = "";
    $data = View::getInstance()->getDataForView();
    if (isset($data['error']['code']))
    {
        $errorCode = $data['error']['code'];
    }
    if (isset($data['error']['message']))
    {
        $errorMessage = $data['error']['message'];
    }
    if (isset($data['error']['back']))
    {
        $backTarget = $data['error']['back'];
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $errorCode; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <style type="text/css">
        body {
            font-family: 'Roboto';
            background: #f44336;
        }

        .logo h1 {
            font-size: 200px;
            color: #fff;
            text-align: center;
            margin-bottom: 1px;
            text-shadow: 1px 1px 6px #555;
            margin-top: 100px;
        }

        .logo p {
            color: white;
            font-size: 20px;
            margin-top: 1px;
            text-align: center;
        }

        .sub a {
            color: #f44336;
            /*background:#fff;*/
            text-decoration: none;
            padding: 5px;
            font-size: 13px;
            font-family: arial, serif;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="logo">
        <h1><?php echo $errorCode; ?></h1>
        <p><?php echo $errorMessage; ?></p>
        <?php if ($backTarget != ""): ?>
            <div class="sub">
                <p><a class="btn-flat white-text" href="<?php echo $backTarget; ?>"><i
                            class="material-icons">arrow_back</i></a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
