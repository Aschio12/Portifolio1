$(document).ready(function () {
    let currentIndex = 0;
    const projects = [
        { address: "./Images/burger-menu.png", description: "This is the description of project 1" },
        { address: "./Images/lines.png", description: "This is the description of project 2" },
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