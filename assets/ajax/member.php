<?php
    spl_autoload_register(function ($class) {
        require __DIR__ . "/../../src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $month_data = $_POST['month_data'];

    $run = $vehicle->getMember($month_data);

    $count = 1;
    while ($row = $run->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $row['owner']; ?></td>
            <td><?php echo $vehicle->viewPlate($row['number_plate']); ?></td>
            <td><?php echo $row['mobile']; ?></td>
            <td><?php echo $row['regdate']; ?></td>
        </tr>
    <?php $count++;
    }
?>