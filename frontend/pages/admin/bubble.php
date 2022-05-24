<div class="d-flex flex-column align-items-center text-center p-3 py-1">
    <img class="rounded-circle mt-2" width="150px" src="https://i.imgur.com/kz8725t.jpeg"><span class="font-weight-bold"><?php echo $ACTIVE_USER_DATA->PrefferedFullName; ?></span>
    <!-- <span class="text-black-50"><?php ?><?php echo $ACTIVE_USER_DATA->ContactEmail; ?></span> -->
    <div class="col-md-12"><label class="labels"><?php echo $ACTIVE_USER_DATA->ContactEmail; ?></label></div>
    <div class="col-md-12"><label class="labels"><?php echo $ACTIVE_USER_DATA->PhoneNumber; ?></label></div>
    <div class="col-md-12"><label class="labels"></label>Birthday:</div>
    <div class="col-md-12"><label class="labels"><?php echo $ACTIVE_USER_DATA->DateOfBirth; ?></label></div>
    <div class="col-md-12"><label class="labels"></label>Status: Online</div>
</div>