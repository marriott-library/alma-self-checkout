<?php
require("login.php");
require("AlmaConnect.php");
$almaConnect = new AlmaConnect();
include("header.php");
if (isset($_POST['barcode'])) {
    $loaned = $almaConnect->loan($user_id, $_POST['barcode']);
}
//This goes after the loan process so it will show the correct number of loans
$user_alma = $almaConnect->loginAlma($user_id);
$user_loans = $almaConnect->loansAlma($user_id);


?>
<div id="content">
<div class="container" id="scanbox">
    <p class="text-right font-weight-bold">Welcome <?= ucwords(strtolower($user_alma->first_name . " " . $user_alma->last_name)) ?></p>
    <div class="databox">
        <div>
            <table cellpadding="0px" cellspacing="0px" class="headertable table">
                <tr>
                    <td><span class="headertablekey">Loans:</span>&nbsp;<span class="headertablevalue" id="userloans"><?=$user_alma->loans->value?></span></td>
                    <td><span class="headertablekey">Requests:</span>&nbsp;<span class="headertablevalue" id="userrequests"><?=$user_alma->requests->value?></span></td>
                    <td><span class="headertablekey">Fines & Fees:</span>&nbsp;<span class="headertablevalue" id="userfees">$<?=number_format((float)$user_alma->fees->value, 2, '.', ',')?></span></td>
                    <td>
                        <form method="post">
                            <input type="submit" name="logout" value="Logout"/>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        if ($loaned)
        {
            if ($loaned->errorsExist)
            {
                echo "<div class='alert alert-danger text-center' role='alert'>" . $loaned->errorList->error[0]->errorMessage . "</div>";
            }
            else
            {
                echo "<div class='alert alert-success text-center' role='alert'>You have successfully checked out<br><div class='font-weight-bold'>{$loaned->title}</div>It is due " . date('m-d-Y', strtotime($loaned->due_date)) . ".</div>";
            }
        }
        ?>
        <br/>
        <p class="lead text-center">Please scan or type your next item:</p>
        <div>
            <form action="index.php" method="post" name="barcodeForm">
                <input class="form-control text-center" type="text" id="barcode" name="barcode" placeholder="Barcode..."/>
            </form>
        </div>
        <br/>
        <div>
            <table cellpadding="0px" cellspacing="0px" class="loanstable table table-striped table-hover" id="loanstable">
                <caption>Your current loans.</caption>
                <tr>
                    <th>Title</th>
                    <th width="15%">Due Date</th>
                </tr>
                <?php
                if ($user_loans)
                {
                    foreach ($user_loans->item_loan as $loan)
                    {
                        echo "<tr><td>{$loan->title}</td><td>".date('m-d-Y', strtotime($loan->due_date))."</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <br/><br/>
</div>
<br/><br/>

<!-- Trigger/Open The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content" id="modalbox">
        <span class="close">x</span>
        <div id="modalheader" class="modalheaderdiv"></div>
        <div id="modalcontent">
        </div>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
