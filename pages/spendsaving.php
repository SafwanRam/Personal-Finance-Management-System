<?php 
// spendsaving
if(isset($_POST["spendsaving"])){
  if(spendsaving($_POST) > 0 ){
    inputMoney($_POST);
    echo "<script> alert('Successed');
          document.location.href = '?url=savings';</script>";
  } else {
    echo mysqli_error($conn);
  }
}
?>
<link rel="stylesheet" href="css/addActivity.css" />
<section id="addBaance" class="flex">
  <form action="" method="post" id="form-add" class="flex">
    <h3 class="form-title">SPENDINGS</h3>
    <div class="activity">
      <label for="avtivity">Activity</label>
      <input type="activity" name="activity" id="activity" required/>
    </div>
    <div class="date">
      <label for="date-out">Date</label>
      <input type="date" name="date" id="date-out" required/>
    </div>
    <div class="nominal">
      <label for="nominal">Amount</label>
      <input type="text" name="nominal" id="nominal" required/>
    </div>
    <input type="hidden" name="activity" value="Dana talangan dari tabungan masadepan" />
    <button type="submit" name="spendsaving" class="btn btn-danger">Send</button>
  </form>
</section>
<script src="logic/addActivity.js"></script>