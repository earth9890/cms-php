<?php
function checkQueryResult($result, $conn)
{
    if (!$result) {
        die("Database query failed: " . $conn->error);
    }
}

function getSubjects($conn)
{
    $query = "SELECT * FROM subjects order by position ASC";
    $subjectResult = $conn->query($query);
    checkQueryResult($subjectResult, $conn);
    return $subjectResult;
}





function getPageByIdForSubjects($conn, $id)
{
    $query = "SELECT * FROM pages WHERE subject_id = {$id} order by position ASC";
    $pageResult = $conn->query($query);
    checkQueryResult($pageResult, $conn);
    return $pageResult;
}