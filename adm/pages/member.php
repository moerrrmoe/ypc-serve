<?php
    require_once __DIR__.'/../../controller/member-controller.php';
    $memberController = new memberController();
    $members = $memberController->getAllMembers();
    if(isset($_GET['search'])){
        $member = $memberController->getMemberById($_GET['search']);
        if($member){
            $members = [array("id"=>$member->id,"exp"=>$member->exp,"fee"=>$member->fee)];
        }else{
            $members = [];
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management</title>
</head>
<?php
        include(__DIR__.'/../components/header.php');
?>
<body>
    <div class="container">
        <h1>Member Management</h1>
        <div class="mb-3">
            <input type="number" id="memberId" class="form-control mb-3" placeholder="Member ID">
            <input onchange="setExp(this.value)" type="date" id="memberExp" class="form-control mb-3" placeholder="Expiry Date">
            <button onclick="submit()" type="button" class="btn btn-primary mb-3">Add Member</button>
            <div class="input-group mb-3">
                <input class="form-control" name="json-upload" accept=".json,application/json" id="json-upload" type="file" >
                <button onclick="importJson()" type="button" class="btn btn-primary">Import</button>
            </div>
        </div>
        <div class="mb-3 input-group">
            <input type="number" id="searchId" class="form-control" placeholder="Search by Member ID">
            <button onclick="location.href='?search=' + document.getElementById('searchId').value" type="button" class="btn btn-primary">Search</button>
        </div>
        <div>
            <ul>
                <li>
                    <b>Total active users: </b><?php echo $memberController->memberCount(); ?>
                </li>
                <li>
                    <b>Total revenue(from active): </b><?php echo $memberController->sumRevenue()."+ Ks"; ?>
                </li>
            </ul>
            <button onclick="bulkDelete()" type="button" class="btn btn-danger">Bulk Delete</button>
        </div>
        <div style="overflow: auto;overflow-x:scroll">
        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Expiry</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="w-100">
                <?php
                foreach($members as $member){
                    echo '<tr>
                            <td>'.$member['id'].'</td>
                            <td><input type="date" value="'.$member['exp'].'" id="exp_'.$member['id'].'" class="form-control" style="width: 200px;" /></td>
                            <td>'.$member['fee'].'</td>
                            <td style="width: 200px;" class="input-group">
                                <button onclick="updateMember(this)" memberId="'.$member['id'].'" type="button" class="btn btn-primary">Update</button>
                                <button onclick="removeMember(this)" memberId="'.$member['id'].'" type="button" class="btn btn-danger">Remove</button>
                            </td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>
    <script src="../js/member.js"></script>

</body>
<?php
        include(__DIR__.'/../components/footer.php');
?>
</html>