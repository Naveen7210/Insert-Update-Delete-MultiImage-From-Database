<?php
include_once 'dbconfig.php';

if (isset($_GET['edit_multiimg_id'])) {
    $sql_query = "SELECT * FROM mulitiimg WHERE id=" . $_GET['edit_multiimg_id'];
    $result_set = mysqli_query($con, $sql_query);
    $fetched_row = mysqli_fetch_array($result_set, MYSQLI_ASSOC);
}
if (isset($_POST['btn-update'])) {

    $totalFiles = count($_FILES['fileImg']['name']);
    $filesArray = array();

    for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = $_FILES["fileImg"]["name"][$i];
        $tmpName = $_FILES["fileImg"]["tmp_name"][$i];

        $imageExtension = explode('.', $imageName);
        $imageExtension = strtolower(end($imageExtension));

        $newImageName = uniqid() . '.' . $imageExtension;

        move_uploaded_file($tmpName, 'images/' . $newImageName);
        $filesArray[] = $newImageName;
    }

    $filesArray = json_encode($filesArray);

    $sql_query = "UPDATE mulitiimg SET `MultiImg`='$filesArray' WHERE id=" . $_GET['edit_multiimg_id'];


    if (mysqli_query($con, $sql_query)) {
?>
        <script type="text/javascript">
            alert('Updated Successfully');
            window.location.href = 'index.php';
        </script>
    <?php
    } else {
    ?>
        <script type="text/javascript">
            alert('error occured while updating data');
        </script>
<?php
    }
}
if (isset($_POST['btn-cancel'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates</title>

    <style>
        @import url(https://fonts.googleapis.com/css?family=Lily+Script+One);

        * {
            margin: 0;
            padding: 0;
            font-family: 'poppins', sans-serif;
        }

        body {
            display: grid;
            height: 100vh;
            justify-content: center;
            align-items: center;
            padding: 1%;
            background-color: lightblue;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            background: #fff;
            padding: 25px 30px;
            border-radius: 5px;
        }

        .container .title::before {
            content: '';
            position: absolute;
            left: 0;
            font-size: 16px;
            bottom: 0;
            height: 5px;
            width: 30px;
        }

        .container form .user-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        form .user-details .input-box {
            margin: 20px 0 12px 0;
            width: calc(100% / 1 - 20px);
        }

        .user-details .input-box .details {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .user-details .input-box input {
            height: 45px;
            width: 100%;
            outline: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding-left: 15px;
            font-size: 16px;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
        }

        .user-details .input-box input:focus,
        .user-details .input-box input:valid {
            border-color: #9b59b6;
        }

        form .button {
            height: 45px;
            margin: 20px 0 12px 0;
            width: calc(100% / 2 - 20px);
        }

        form .button input {
            height: 100%;
            width: 100%;
            outline: none;
            color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            border-radius: 5px;
            letter-spacing: 1px;
            background: lightblue;
        }

        @media (max-width: 600px) {
            .container {
                max-width: 100%;
            }

            form .user-details .input-box {
                margin-bottom: 15px;
                width: 100%;
            }

            .container form .user-details {
                max-height: 300px;
                overflow-y: scroll;
            }

            .user-details::-webkit-scrollbar {
                width: 0;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="title">Edit Details</div>
        <form method="post" enctype="multipart/form-data">

            <div class="user-details">
                <div class="input-box">
                    <span for="MultiImg" class="details">MultiImg</span>
                    <input style="outline: none; padding-left: 15px; padding-top: 15px; font-size: 16px; border-radius: 0px; border: 0px; border-bottom-width: 2px; transition: all 0.3s ease;" type="file" accept=".jpg, .jpeg, .png" multiple name="fileImg[]">
                </div>
            </div>

            <div class="user-details">
                <div class="button">
                    <input type="submit" name="btn-update" value="Update">
                </div>
                <div class="button">
                    <input type="submit" name="btn-cancel" value="Cancel">
                </div>
            </div>

        </form>
    </div>

</body>

</html>

