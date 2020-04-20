<?php

$server = 'localhost';
$username = 'root';
$password = '';
$db_name = 'spk';

$conn = mysqli_connect($server, $username, $password, $db_name);

//if(!$conn){
//   echo "Database Tidak Terkoneksi!";
//}else{
//    echo "Database Terkoneksi!";
//}

//Penentuan Bobot
$bobot = array(0.25, 0.25, 0.5);
echo "<center> <h3>Data Bobot</h3> </center><hr /><br />";
echo "<center>";
for($x=0;$x<count($bobot);$x++){
    echo 'Index Ke '.$x.' = ' .$bobot[$x].'<br />';
}
echo "</center>";
echo "<br /><br />"

?>



<!-- Data Alternatif -->

<table border="1" class="table table-striped">
<thead>
    <tr>
        <th>ID</th>
        <th>Alternatif</th>
    </tr>
</thead>
<tbody>
    <?php
    echo "<center> <h3>Data Alternatif</h3> </center><hr /><br />";
        $sql = mysqli_query($conn, 'SELECT id, alternatif FROM tb_alternatif');
        while ($r = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $r['id'] ?></td>
            <td><?php echo $r['alternatif'] ?></td>
        </tr>
    <?php
    }
    ?>
</tbody>
</table>
<?php echo "<br /><br />" ?>


<!-- Data Matrix -->

<table border="1" class="table table-striped">
<thead>
    <tr>
        <th>ID</th>
        <th>Alternatif</th>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
    </tr>
</thead>
<tbody>
    <?php
    echo "<center> <h3>Data Matrix</h3> </center><hr /><br />";
        $sql1 = mysqli_query($conn, 'SELECT * FROM tb_alternatif');
        while ($r1 = mysqli_fetch_array($sql1, MYSQLI_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $r1['id'] ?></td>
            <td><?php echo $r1['alternatif'] ?></td>
            <td><?php echo $r1['c1'] ?></td>
            <td><?php echo $r1['c2'] ?></td>
            <td><?php echo $r1['c3'] ?></td>
        </tr>
    <?php
    }
    ?>
</tbody>
</table>
<?php echo "<br /><br />" ?>


<!-- Normalisasi Data -->

<table border="1" class="table table-striped">
<thead>
    <tr>
        <th>ID</th>
        <th>Alternatif</th>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
    </tr>
</thead>
<tbody>
    <?php
    echo "<center> <h3>Data Ternormalisasi</h3> </center><hr /><br />";
    $atribut = mysqli_query($conn, 'SELECT MIN(C1) as Min1, MAX(c2) as Max1, MAX(c3) as Max2 FROM tb_alternatif');

    $atr = mysqli_fetch_array($atribut);
    
        $sql2 = mysqli_query($conn, 'SELECT * FROM tb_alternatif');
        while ($r2 = mysqli_fetch_array($sql2, MYSQLI_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $r2['id'] ?></td>
            <td><?php echo $r2['alternatif'] ?></td>
            <td><?php echo ($atr['Min1']/$r2['c1']) ?></td>
            <td><?php echo ($r2['c2']/$atr['Max1']) ?></td>
            <td><?php echo ($r2['c3']/$atr['Max2']) ?></td>
        </tr>
    <?php
    }
    ?>
<tbody>
</table>
<?php echo "<br /><br />" ?>


<!-- Mengkalkulasi Nilai Preferensi -->

<table border="1" class="table table-striped">
<thead>
    <tr>
        <th>ID</th>
        <th>Alternatif</th>
        <th>Total Point</th>
    </tr>
</thead>
    <?php
    echo "<center> <h3>Data Nilai Preferensi</h3> </center><hr /><br /> ";
    $atribut1 = mysqli_query($conn, 'SELECT MIN(C1) as Min1, MAX(c2) as Max1, MAX(c3) as Max2 FROM tb_alternatif');

    $atr1 = mysqli_fetch_array($atribut1);
    
        $sql3 = mysqli_query($conn, 'SELECT * FROM tb_alternatif');
        while ($r3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)) {
            $point = ((($atr1['Min1']/$r3['c1'])*$bobot[0])+(($r3['c2']/$atr1['Max1'])*$bobot[1])+(($r3['c3']/$atr1['Max2'])*$bobot[2]));
    ?>
        <tr>
            <td><?php echo $r3['id'] ?></td>
            <td><?php echo $r3['alternatif'] ?></td>
            <td><?php echo $point ?></td>
        </tr>
    <?php
    }
    ?>
</table>