function confirmDeletion()
{
    return confirm("Record will be permanently deleted. Are you sure?");
}

function alertMessage()
{
    alert("Please de-allocate all patients assigned to this doctor before continuing with the deletion.");
    return false;
}