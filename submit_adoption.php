<?php
include 'db_connect.php'; // This file should set up the $conn variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect input data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $maritalStatus = $_POST['maritalStatus'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zipCode'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $employer = $_POST['employer'];
    $occupation = $_POST['occupation'];
    $annualIncome = $_POST['annualIncome'];
    $childAge = $_POST['childAge'];
    $childGender = $_POST['childGender'];
    $familyMembers = $_POST['familyMembers'];
    $children = $_POST['children'];
    $familyBackground = $_POST['familyBackground'];
    $residenceType = $_POST['residenceType'];
    $ownership = $_POST['ownership'];
    $healthInsurance = $_POST['healthInsurance'];
    $healthStatus = $_POST['healthStatus'];
    $reference1Name = $_POST['reference1Name'];
    $reference1Phone = $_POST['reference1Phone'];
    $reference1Email = $_POST['reference1Email'];
    $experience = $_POST['experience'];
    $motivation = $_POST['motivation'];

    $sql = "INSERT INTO adoption_applications (
        first_name, last_name, dob, marital_status, address, city, state, zip_code,
        phone, email, employer, occupation, annual_income, child_age, child_gender,
        family_members, children, family_background, residence_type, ownership,
        health_insurance, health_status, reference_name, reference_phone, reference_email,
        experience, motivation
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssssss",
        $firstName, $lastName, $dob, $maritalStatus, $address, $city, $state, $zipCode,
        $phone, $email, $employer, $occupation, $annualIncome, $childAge, $childGender,
        $familyMembers, $children, $familyBackground, $residenceType, $ownership,
        $healthInsurance, $healthStatus, $reference1Name, $reference1Phone, $reference1Email,
        $experience, $motivation
    );

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
