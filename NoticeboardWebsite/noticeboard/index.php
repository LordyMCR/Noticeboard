<?php

require_once "header.php";

$selected1 = $selected2 = $selected3 = $selected4 = $selected5 = $selected6 = $selected7 = "";

//  if sort button posted, keep selected value displaying in the dropdown once submitted.
//  sort button being managed by jquery script to cooperate with dynamic updating
if (isset($_POST['sort'])) {
    if ($_POST['sort'] == "titleAZ")
    {
        $selected2 = "selected";
    }
    elseif ($_POST['sort'] == "titleZA")
    {
        $selected3 = "selected";
    }
    elseif ($_POST['sort'] == "contentAZ")
    {
        $selected4 = "selected";
    }
    elseif ($_POST['sort'] == "contentZA")
    {
        $selected5 = "selected";
    }
    elseif ($_POST['sort'] == "dateNewOld")
    {
        $selected6 = "selected";
    }
    elseif ($_POST['sort'] == "dateOldNew")
    {
        $selected7 = "selected";
    }
    else
    {
        $selected1 = "selected";
    }
}

//  display sort dropdown and button, as well as a starting div.
//  starting div is used by jquery to append content from the database dynamically
echo <<<_END
    <select class="btn-sm form-select" name="sort" id="sortV1">
        <option value="default" {$selected1}>Default</option>
        <option value="titleAZ" {$selected2}>Title A-Z</option>
        <option value="titleZA" {$selected3}>Title Z-A</option>
        <option value="contentAZ" {$selected4}>Content A-Z</option>
        <option value="contentZA" {$selected5}>Content Z-A</option>
        <option value="dateNewOld" {$selected6}>Date New-Old</option>
        <option value="dateOldNew" {$selected7}>Date Old-New</option>
    </select>
    <button type="submit" class="btn btn-sm btn-primary" id="sortBtnV1">Sort</button>
    <input type="hidden" id="sortHidden" value="0">
    <hr>
    <div class='row gy-4' id="append">
_END;

echo "</div>";

require_once "footer.php";

?>