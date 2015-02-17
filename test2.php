<?php
include('includes.php');
include('header.php');
$user_type = $_SESSION['usertype'];

echo '<h1>Exploration!</h1>';
?>


<link rel='stylesheet' type='text/css' href='datepicker/css/datepicker.css' />
<link rel='stylesheet' type='text/css' href='datepicker/less/datepicker.less' />
<script type="text/javascript" src="datepicker/js/bootstrap-datepicker.js"></script>  
<script type="text/javascript">
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})；
$('#myTab a[href="#profile"]').tab('show'); // Select tab by name

$('a[data-toggle="tab"]').on('shown', function (e) {
  e.target // activated tab
  e.relatedTarget // previous tab
})；

$('#myModal').modal(options)；
$('#myModal').modal({
  keyboard: false
})；
$('#myModal').modal('toggle')；
$('#myModal').modal('show')；
$('#myModal').modal('hide')；
$(document).ready(function() {
$('#datepicker').datepicker({
    format: 'mm-dd-yyyy'
});


</script>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">
    <p><?php include("updateMember.php"); ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>


<ul class="nav nav-tabs">
  <li class="active"><a href="#members" data-toggle="tab">Members</a></li>
  <li><a href="#events" data-toggle="tab">Events</a></li>
  <li><a href="#volopprt" data-toggle="tab">Volunteer Opportunities</a></li>
  <li><a href="#manageemp" data-toggle="tab">Manage Employees</a></li>
  <li><a href="#org" data-toggle="tab">Organizations</a></li>
  <li><a href="#childrecord" data-toggle="tab">Children Records</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="members"><?php include("manageMember-test.php"); ?></div>
  <div class="tab-pane" id="events">
	<label for="date">Birthday:</label>
	<input type="text" value="02-16-2012" id="datepicker">
</div>
  <div class="tab-pane" id="volopprt">.adf..</div>
  <div class="tab-pane" id="manageemp">.ffsfd..</div>
  <div class="tab-pane" id="org">..bdfb.</div>
  <div class="tab-pane" id="childrecord">.eqef.</div>
</div>
 
<script>
  $(function () {
    $('#myTab a:last').tab('show');
  })
</script>