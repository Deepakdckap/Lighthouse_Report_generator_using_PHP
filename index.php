<?php
//connection
$db = new PDO
(
    'mysql:host=127.0.0.1;dbname=lighthouse',
    'dckap',
    'Dckap2023Ecommerce'
);

$fetch = $db->query("SELECT * from qa_lighthouse");
$data = $fetch->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lighthouse</title>
    <link rel="icon" href="data:image/svg+xml;utf8,<svg fill=&quot;none&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 48 48&quot;><path d=&quot;m14 7 10-7 10 7v10h5v7h-5l5 24H9l5-24H9v-7h5V7Z&quot; fill=&quot;%23F63&quot;/><path d=&quot;M31.561 24H14l-1.689 8.105L31.561 24ZM18.983 48H9l1.022-4.907L35.723 32.27l1.663 7.98L18.983 48Z&quot; fill=&quot;%23FFA385&quot;/><path fill=&quot;%23FF3&quot; d=&quot;M20.5 10h7v7h-7z&quot;/></svg>">    <script src="https://kit.fontawesome.com/53c4033439.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form {
            margin-bottom: 20px;
        }

        .form h2 {
            color: #333;
        }

        .input_field {
            margin-bottom: 20px;
        }

        .label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="url"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:invalid{
            animation: shake 300ms;
            color: red;
        }
        @keyframes shake{
            25%{
                transform: translateX(4px);
            }
            50%{
                transform: translateX(-4px);
            }
            75%{
                transform: translateX(4px);
            }
        }

        input[type="submit"] {
            background-color: #77a2d3;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #1659a3;
        }

        .table {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #77a2d3;
            color: #fff;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action_elements{
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }

        .download{
            color: #77a2d3;
            font-size: 18px;
            /*padding-right: 5px;*/
        }

        .view{
            color: #216121;
            font-size: 18px;
            /*padding-right: 5px;*/
        }

        .delete{
            background: none;
            border: none;
            color: red;
            font-size: 18px;
            cursor: pointer;
        }

        span{
            background-color: #151414;
            width: 2px;
            height: 18px;
            margin: 8px;
        }

        .err{
            text-align: center;
            background-color: #e03d3d;
            color: #f1f1f1;
            border-radius: 10px;
            padding: 15px;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="container">

    <div class="form">
        <h2>Lighthouse report Generator</h2>
        <form action="lighthouse.php" method="post">
            <div class="input_field">
                <label>Project name</label>
                <input type="text" name="project_name" required pattern="[a-z,A-Z,_]*" placeholder="Project_name...">
                <input type="text" hidden name="p_n">
            </div>

            <div class="input_field">
                <label>Website URL</label>
                <input type="url" name="url" required placeholder="https://example.com/">
            </div>

            <input type="submit" name="generate" value="Generate">
        </form>
    </div>

    <div class="table">
        <?php if($data): ?>

            <table border="1">
                <tr>
                    <th>Project name</th>
                    <th>Website</th>
                    <th>Actions</th>
                    <th>Created_at</th>
                </tr>

                <?php foreach($data as $value):?>
                    <tr>
                        <td>
                            <?= $value->hidden_p_n ?>
                        </td>
                        <td>
                            <a href="<?= $value->siteURL ?>" target="_blank"><?= $value->siteURL ?></a>
                        </td>
                        <td class="action_elements">
                            <a href="<?= $value->filePath ?>" class="view" target="_blank"><i class="fa-solid fa-eye"></i></a>

                            <span></span>

                            <a download href="<?= $value->filePath ?>" class="download"><i class="fa-solid fa-download"></i></a>

                            <span></span>

                            <form action="delete.php" method="post">
                                <input hidden value="<?php echo $value->id ?>" name="deleteToId">
                                <button type="submit" name="delete" class="delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                        <td>
                            <?= $value->created_at ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <p class="err">Records not found</p>

            <?php endif; ?>
        </table>
    </div>

</div>

</body>
</html>
