$(document).ready(function () {
  // Remove all form handling code and just keep the carousel

  // Project carousel functionality
  let currentIndex = 0;
  const projects = [
    {
      address: "./Images/p1.jpg",
      link: "https://github.com/Aschio12/Betachin-app",
      description:
        "Betachin is a mobile app where users can easily buy, sell, or rent any type of building, including houses, apartments, and offices. It connects property owners with interested buyers or renters in a simple, user-friendly platform.",
    },
    {
      address: "./Images/welll.webp",
      link: "https://github.com/Aschio12/Wellness-Wise",
      description:
        "WellnessWise is a modern gym website offering fitness plans, trainer bookings, and wellness tips to help users achieve their health goals.",
    },
  ];

  const leftBtn = $("#left-btn");
  const description = $("#description");
  const projectImage = $("#project-image");
  const rightBtn = $("#right-btn");
  const detailLink = $("#For\\ detail");

  function updateDisplay() {
    description.text(projects[currentIndex].description);
    projectImage.css("background-image", `url(${projects[currentIndex].address})`);
    detailLink.attr("href", projects[currentIndex].link);
  }

  updateDisplay();

  rightBtn.click(function() {
    currentIndex = (currentIndex < projects.length - 1) ? currentIndex + 1 : 0;
    updateDisplay();
  });

  leftBtn.click(function() {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : projects.length - 1;
    updateDisplay();
  });
});