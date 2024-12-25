<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'student_grade';
$con = mysqli_connect($hostname,$username,$password,$dbname);

function stringValidation($value){
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    $value = stripcslashes($value);
    return $value;
}

if(isset($_POST['submit'])){
$name = stringValidation($_POST['name']);
$grades = [
     $_POST['grade1'],
     $_POST['grade2'],
     $_POST['grade3'],
     $_POST['grade4']
];

function calc_avg($grades){
$sum = array_sum($grades);
$avg = $sum / count($grades); 
return $avg;
}
$avg = calc_avg($grades);
$insertQuery = "INSERT INTO `student` VALUES (null,'$name',$grades[0],$grades[1],$grades[2],$grades[3],$avg)";
$insert = mysqli_query($con,$insertQuery);
if($insert){
    header("location:index.php");
}

}




$selectQuery = "SELECT * FROM student";
$select = mysqli_query($con , $selectQuery);
$rows = mysqli_num_rows($select);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades</title>
<style>

        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212; 
            color: #e0e0e0; /
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #1e1e1e; 
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            margin-bottom: 20px;
        }

        .form-container h1 {
            text-align: center;
            color: #4caf50; 
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #e0e0e0; /
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 8px;
            font-size: 16px;
            background-color: #333;
            color: #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-container input:focus {
            border-color: #4caf50;
            background-color: #444;
            outline: none;
        }

        .form-container button {
            width: 100%;
            background-color: #4caf50;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background-color: #45a049;
        }
        .table-container {
            width: 100%;
            max-width: 800px;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            background-color: #1e1e1e;
            border-radius: 8px;
            color: #e0e0e0;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #4caf50; 
            color: white;
            font-weight: bold;
        }

        td {
            border-top: 1px solid #333;
        }

        tr:nth-child(even) {
            background-color: #333; 
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #888;
            font-size: 18px;
        }

</style>
</head>
<body>
    <div class="form-container">
        <h1>Student Grades</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="grade1">Grade 1:</label>
            <input type="number" id="grade1" name="grade1" min="0" max="100" required>

            <label for="grade2">Grade 2:</label>
            <input type="number" id="grade2" name="grade2" min="0" max="100" required>

            <label for="grade3">Grade 3:</label>
            <input type="number" id="grade3" name="grade3" min="0" max="100" required>

            <label for="grade4">Grade 4:</label>
            <input type="number" id="grade4" name="grade4" min="0" max="100" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
    <div class="table-container">
        <h2>Student Averages</h2>
        <table>
            <thead>
                <tr>
                   <th>Name</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
            <?php if($rows > 0):?>   
            <?php foreach($select as $student):?>
                <tr>
                   <td><?=$student['name']?></td>
                   <td><?=$student['avg']?></td>
                </tr>
            <?php endforeach; ?>
            <?php else:?>
                <tr>
                <td colspan="2">NO DATA TO SHOW</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</body>
</html>

