<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Slider</title>
    <style>
        .slider {
            width: 80%;
            margin: auto;
            overflow: hidden;
            position: relative;
        }
        .slider img {
            width: 100%;
            transition: transform 0.5s ease-in-out;
        }
        .slider-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="slider" id="slider">
    <!-- Slides will be inserted here by JavaScript -->
</div>

<script>
    fetch('fetch_news.php')
        .then(response => response.json())
        .then(newsArray => {
            const slider = document.getElementById('slider');
            let sliderHTML = '';

            newsArray.forEach((news, index) => {
                sliderHTML += `
                    <div class="slide" style="transform: translateX(-${index * 100}%);">
                        <img src="${news.image_url}" alt="${news.title}">
                        <div class="slider-content">
                            <h2>${news.title}</h2>
                            <p>${news.description}</p>
                        </div>
                    </div>
                `;
            });

            slider.innerHTML = sliderHTML;

            let currentSlide = 0;
            setInterval(() => {
                currentSlide = (currentSlide + 1) % newsArray.length;
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            }, 3000);
        })
        .catch(error => console.error('Error fetching news:', error));
</script>

</body>
</html>
