<?php

include '../../includes/db.php';

$generalFund = $_POST["general_fund"];
$lastYearInterest = $_POST["last_year_interest"];
$addedInterest = $_POST["added_interest"];
$asPerLastBalanceSheet = $_POST["as_per_last_balancesheet"];
$assetsAsPerLastBalanceSheet = $_POST["assets_as_per_last_balancesheet"];
$expenseMoreThanIncome = $_POST["expense_more_than_income"];
$auditFee = $_POST["audit_fee"];
$accountingCharges = $_POST["accounting_charges"];
$deprecationPercentage = $_POST["deprecation_percentage"];
$prevFurnitureValue = $_POST["furniture_value"];
$otherAssets = $_POST["other_assets"];
$prevSignBoardValue = $_POST["sign_board_value"];
$prevFanValue = $_POST["fan_value"];
$prevTvValue = $_POST["tv_value"];
$mukutGold = $_POST["mukut_gold"];


$id=1;

echo $query = "UPDATE past_year_amounts SET general_fund='$generalFund', last_year_interest='$lastYearInterest', added_interest='$addedInterest', as_per_last_balancesheet='$asPerLastBalanceSheet', expense_more_than_income='$expenseMoreThanIncome', audit_fee='$auditFee', accounting_charges='$accountingCharges', assets_as_per_last_balancesheet='$assetsAsPerLastBalanceSheet', deprecation_percentage='$deprecationPercentage', furniture_value='$prevFurnitureValue', other_assets='$otherAssets', sign_board_value='$prevSignBoardValue', fan_value='$prevFanValue', tv_value='$prevTvValue', mukut_gold='$mukutGold' WHERE id='$id'";

if(mysqli_query($conn,$query)){
    header('Location: '.$app_url.'reports/balancesheet.php'); 
}else {
    echo mysqli_error($conn);
}

?>