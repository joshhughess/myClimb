<?php
include('connect.php');
include_once('simple_html_dom.php');
$connect = mysqli_connect($host,$userName,$password, $db);
include('styleLinks.php');
if(isset($_SESSION['username'])){
    include('navLogin.php');
    $username = $_SESSION['username'];
}else{
    header("Location:index.php?notLoggedin");
}
if($_POST['climbID']){
    $climbID=mysqli_real_escape_string($connect,$_POST['climbID']);
    echo "<title>Review - ".findClimbName($climbID)."</title>";
    $sql = "INSERT INTO hasClimbed(climbID,userID) VALUES ('".$climbID."','".$_SESSION['userID']."')";
    $res = mysqli_query($connect,$sql);
    if($res){
        echo '<div class="row">
                <div class="col s12">
                    <div class="card blue lighten-4">
                        <div class="card-content">
                            <span class="card-title">You\'ve climbed <b>' . findClimbName($_POST['climbID']) . '</b></span>
                            <p>Feel free to leave a review below!</p>
                        </div>
                    </div>
                </div>
           </div>';
        echo "<form method='post' action='sendReview.php'>";
        echo "<input name='climbID' hidden type='text' value='".$climbID."'>";
        echo "<input name='rating' class='theRating' hidden type='text'>";
        echo '<div class=\'row\'><div class="input-field col s12">';
        echo "<label for='reviewTitle'>Title for review</label>";
        echo "<input type='text' required='required' maxlength='100' data-length='100' id='reviewTitle' name='reviewTitle'>";
        echo "</div></div>";
        echo '<div class=\'row\'><div class="input-field col s12">';
        echo "<label for='reviewComments'>Leave your comments about the climb here</label>";
        echo "<input type='text' required='required' maxlength='250' data-length='250' id='reviewComments' name='reviewComments'>";
        echo "</div></div>";
        echo "<p>Star Rating:</p>";
        echo "<select id='starRating'>";
        echo "  <option value='1'>1</option>";
        echo "  <option value='2'>2</option>";
        echo "  <option value='3'>3</option>";
        echo "  <option value='4'>4</option>";
        echo "  <option value='5'>5</option>";
        echo "</select>";
        echo "<button class='btn waves-effect green darken-2' type='submit' name='saveReview'>Save your review</button>";
        echo "</form>";
    }else{
        echo "something went wrong please try again";
    }
}
?>
<script>
    $(function() {
        $('#reviewTitle, #reviewComments').characterCounter();
        $('#starRating').barrating({
            theme: 'fontawesome-stars',
            onSelect: function(value, text, event) {
                if (typeof(event) !== 'undefined') {
                    // rating was selected by a user
                    $('.theRating').val(value);
                    console.log(value);
                }
            }
        });
    });
</script>
<?php include('footer.php');?>

