//Open dialog to add a channel.
function askAddChannel() {
     //Open the overlay.
     Toggleoverlay('open',0);

     //Set the correct content in the dialog.
     heading = "Add a channel.";
     body = "<p>You can only add RSS-feeds dynamically, since they work dynamically.</p>"
     body += "<div class='form-group'> <label>Name</label> <input type='text' class='form-control' id='channelName'placeholder='Enter Name..'>";
     button = " <button class='btn btn-primary' onclick='addChannel()'>Add</button>";
     openDialog(heading,body,button);
}//Function askAddChannel.

//Add the channel.
function addChannel() {
    //Get values.
    name = document.getElementById('channelName').value;

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            name:name,
            canUnpublish:1,
            type:2,
            addChannel:"addChannel"
        },
        success: function(data) {
            $(".channels-alert-messages").html(data);
            Toggleoverlay('close',0);
            showChannels();
        },
    });
}//Function addChannel.

//Displays channels on the screen without page reload.
function showChannels() {
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            showChannels:"showChannels"
        },
        success: function(data) {
            $(".channels-channel-table").html(data);
        },
    });
}//Function showChannels.

//Open dialog, ask to delete channel.
function askDeleteChannel(channelID) {
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Add a channel.";
    body = "<p>Are you sure you want to delete this channel?</p>";
    button = "<button class='btn btn-primary' onclick='deleteChannel("+channelID+")'>Delete</button>";
    openDialog(heading,body,button);
}//Function askDeleteChannel.

//Delete channel.
function deleteChannel(channelID) {
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            channelID:channelID,
            deleteChannel:"deleteChannel"
        },
        success: function(data) {
            $(".channels-alert-messages").html(data);
            Toggleoverlay('close',0);
            showChannels();
        },
    });
}//Function deleteChannel.