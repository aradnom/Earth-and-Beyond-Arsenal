<?php if(isset($conn)) { ?>
<table class="footer" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="center">
          <?php if(!isset($contactset)) { ?>
          <div style="z-index:3; margin-bottom:10px;"><a href="contact.php" target="_blank"><img src="assets/feedbackbutton.png" border="0" /></a></div>
          <?php } ?>
        <img src="assets/footer.png" width="656" height="33" usemap="#footer" border="0"/>        
        </td>        
    </tr>
</table>

<div class="footerbar">	
    <div class="admin"><a href="admin/index.php" target="_blank">Admin</a></div>
</div>
<?php } ?>