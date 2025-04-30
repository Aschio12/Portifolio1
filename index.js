$(document).ready(function () {
    $('#get-in-touch-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        // Show loading state
        $('#status').html('<p class="text">Sending message...</p>');
        
        // Collect form data
        var formData = $(this).serialize();
        
        // Send form data via AJAX
        $.ajax({
            url: 'process_form.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message
                    $('#status').html('<p class="gradient-text">' + response.message + '</p>');
                    // Clear the form
                    $('#get-in-touch-form')[0].reset();
                } else {
                    // Show error message
                    $('#status').html('<p style="color: red;">' + response.message + '</p>');
                }
            },
            error: function() {
                // Show generic error message
                $('#status').html('<p style="color: red;">Something went wrong. Please try again later.</p>');
            }
        });
    });


    let currentIndex = 0;
    const projects = [
        { address: "./Images/p1.jpg", description: "This is the description of project 1" },
        { address: "./Images/python.png", description: "This is the description of project 2" },
    ];

    const leftBtn = $("#left-btn");
    const description = $("#description");
    const projectImage = $("#project-image");
    const rightBtn = $("#right-btn");

    // Initial display
    description.text(projects[currentIndex].description);
    projectImage.css("background-image", `url(${projects[currentIndex].address})`);

    function updateDisplay() {
        description.text(projects[currentIndex].description);
        projectImage.css("background-image", `url(${projects[currentIndex].address})`);
    }

    // Right button click
    rightBtn.click(function () {
        if (currentIndex < projects.length - 1) {
            currentIndex += 1;    
        } else {
            currentIndex = 0;
        }
        updateDisplay();
    });

    // Left button click
    leftBtn.click(function () {
        if (currentIndex > 0) {
            currentIndex -= 1;
        } else {
            currentIndex = projects.length - 1;
        }
        
        updateDisplay();
    });
});
