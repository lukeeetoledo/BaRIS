<?php 
include 'SYSTEM_config.php';
date_default_timezone_set('Asia/Manila');

if(isset($_GET['token']) && isset($_GET['prcs'])){
    $creator_ID = $_GET['token'];
    $registration_ID = $_GET['prcs'];
    $date_Created = date(DATE_RFC822);
    // GETTING BARANGAY ID
    $query_Get_brgy = "SELECT * FROM barangay_users_tbl WHERE user_ID = '$creator_ID'";
    $result_Get_brgy = mysqli_query($conn, $query_Get_brgy);

    if(mysqli_num_rows($result_Get_brgy) > 0){
        $row_rGb = mysqli_fetch_assoc($result_Get_brgy);
        $brgy_ID = $row_rGb['user_Barangay'];

        // INSERTING APPROVED REGISTRATION
        $query_Insert_registration = "INSERT INTO system_registered_bgy_tbl SET barangay_ID = '$brgy_ID', registration_ID = '$registration_ID', barangay_Creator = '$creator_ID',  barangay_Joined = '$date_Created'";
        $result_Insert_registration = mysqli_query($conn, $query_Insert_registration);
        if($result_Insert_registration){
            $query_Update_status_A = "UPDATE system_brgy_registration_tbl SET request_Status = '1' WHERE process_ID = '$registration_ID' ;";
            $result_Update_status_A = mysqli_query($conn, $query_Update_status_A);
            $query_Update_status_B = "UPDATE system_accounts_tbl SET account_Type = '3' WHERE user_ID = '$creator_ID'";
            $result_Update_status_B = mysqli_query($conn, $query_Update_status_B);
            if($result_Update_status_A){
                if($result_Update_status_B){
                    echo '<script>alert("Barangay Registration Accepted!"); window.location.href="dashboard.php"</script>';
                }else{
                    echo $conn->error;
                }
            }else{
                echo $conn->error;
            }
        }
    }
}

?>