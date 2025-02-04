const searchInput = document.querySelector("#searchInput");
    const searchResults = document.querySelector("#searchResults");

    searchInput.addEventListener("input", async (e) => {
        const search = e.target.value.toLowerCase();
        if (search.trim() === "") {
            searchResults.style.display = "none";
            searchResults.innerHTML = ""; // Clear results
            return;
        }

        try {
            const response = await fetch(`../../controllers/searchCourse.php?search=${search}`);
            const data = await response.json();

            if (data.status == 1 && data.courses.length > 0) {
                searchResults.innerHTML = ""; 
                searchResults.style.display = "block";

                data.courses.forEach(course => {
                    const courseItem = document.createElement("div");
                    courseItem.style.padding = "10px";
                    courseItem.style.borderBottom = "1px solid #ddd";
                    courseItem.style.cursor = "pointer";

                    courseItem.innerHTML = `
                        <h4 style="margin: 0; color: #333;">${course.title}</h4>
                        <p style="margin: 0; font-size: 12px; color: #666;">${course.description.substring(0, 100)}...</p>
                    `;

                });
            } else {
                searchResults.innerHTML = `<div style="padding: 10px; color: #666;">No courses found.</div>`;
            }
        } catch (error) {
            console.error("Error fetching courses:", error);
        }
    });
    searchInput.addEventListener("blur", () => {
        setTimeout(() => {
            searchResults.style.display = "none";
        }, 200);
    });

    searchInput.addEventListener("focus", () => {
        if (searchResults.innerHTML.trim() !== "") {
            searchResults.style.display = "block";
        }
    });