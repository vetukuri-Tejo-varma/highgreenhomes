from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
import os
import requests
import time

def fetch_image_urls_with_selenium(search_url, limit=30):
    # Set up Selenium
    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))
    driver.get(search_url)
    time.sleep(5)  # Wait for images to load

    image_urls = []
    images = driver.find_elements(By.CSS_SELECTOR, 'img.mimg')  # Adjust selector as needed

    for img in images[:limit]:
        src = img.get_attribute('src')
        if src:
            image_urls.append(src)

    driver.quit()
    return image_urls

def download_image(url, folder_path, img_number):
    try:
        response = requests.get(url, stream=True)
        if response.status_code == 200:
            file_path = os.path.join(folder_path, f'image_{img_number}.jpg')
            with open(file_path, 'wb') as file:
                for chunk in response.iter_content(1024):
                    file.write(chunk)
            print(f"Downloaded: {file_path}")
        else:
            print(f"Failed to retrieve image from {url}")
    except Exception as e:
        print(f"Error downloading {url}: {e}")

def download_images_from_links(search_urls, category_names, base_folder):
    for category, url in zip(category_names, search_urls):
        print(f"Downloading images for category: {category}")
        folder_path = os.path.join(base_folder, category)
        os.makedirs(folder_path, exist_ok=True)

        image_urls = fetch_image_urls_with_selenium(url)

        for i, image_url in enumerate(image_urls):
            if image_url:  # Check if the URL is valid
                download_image(image_url, folder_path, i + 1)

# List of search URLs and corresponding category names
search_urls = [
    "https://www.bing.com/images/search?q=cloth+curtain+for+home",
  
    

]

category_names = [
  "cloth curtain for home",
]

base_folder = r"D:\categories"  # Set your base folder path here

download_images_from_links(search_urls, category_names, base_folder)
