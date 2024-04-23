from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time
import mysql.connector
from datetime import datetime
import schedule
import urllib.request as req
import bs4
import ssl
from webdriver_manager.chrome import ChromeDriverManager

def crawler():
    connection = mysql.connector.connect(host='localhost', port='3306', user='root', passwd='123', database='vaccine_app')
    cursor = connection.cursor()
    ssl._create_default_https_context = ssl._create_unverified_context
    #更新幾筆資料
    cursor.execute("SELECT `updateNews_ctr` FROM `ctr`;")
    count = cursor.fetchone()[0]

    total_pages = 2 
    base_url = "https://www.cdc.gov.tw/Bulletin/List/MmgtpeidAR5Ooai4-fgHzQ"
    #抓取資料庫中消息的最新時間
    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='article';") 
    last_date = cursor.fetchone()[0]
    #如果沒有資料庫中沒有該分類消息則時間預設為2023-11-19
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("article 最新時間: ",last_date)
    for page in range( total_pages,0,-1):
        url = f"{base_url}?page={page}"
        with req.urlopen(url) as response:
            data = response.read().decode("utf-8")
            root = bs4.BeautifulSoup(data, "html.parser")
            content_boxes = root.find_all('div', class_="content-boxes-v3")
            reversed_content_boxes = content_boxes[::-1] 
            for box in reversed_content_boxes:
                title = box.find('a', title=True)
                href = 'https://www.cdc.gov.tw/' + title["href"]
                title_text = title["title"]
                icon_year = box.find('p', class_='icon-year').get_text()
                icon_date = box.find('p', class_='icon-date').get_text()
                # time_str = icon_year + '-' + icon_date
                # time_str = time_str.replace(' ', '').replace('-', '')
                # date_obj = datetime.strptime(time_str, "%Y%m%d").date()
                year_month_parts = icon_year.split('-')
                if len(year_month_parts) == 2:
                    year, month = map(int, year_month_parts)
                    day = int(icon_date)
                    date_obj = datetime(year, month, day).date()
                else:
                    # 處理無法解析日期的情況
                    print("無法解析的日期格式: ", icon_year, icon_date)
                #如果抓取的消息時間大於資料庫中的最新時間則加入
                if(date_obj>last_date):
                    cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'article')", (date_obj ,title_text,href))
                    print("標題: ",title_text)
                    print("連結: ",href)
                    print("時間: ",date_obj)
                    count +=1
                    
    time.sleep(1)

    #webdriver相關設定
    options = Options()
    options.add_argument("--headless")
    options.add_argument("--disable-gpu")
    # options.chrome_executable_path = "C:/topic_python/chromedriver.exe"
    # driver = webdriver.Chrome(options=options)
    chrome_path = ChromeDriverManager().install()
    driver = webdriver.Chrome(options=options)
    #爬蟲網址
    driver.get("https://www.cdc.gov.tw/Advocacy/SubIndex/2xHloQ6fXNagOKPnayrjgQ?diseaseId=N6XvFa1YP9CXYdB0kNSA9A")
    #避免長時間等待
    wait = WebDriverWait(driver, 20)
    driver.maximize_window()


    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='video-1';")
    last_date = cursor.fetchone()[0]
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("video-1 最新時間: ",last_date)
    #第一個欄位選擇為空氣或飛沫傳染
    dropdown = Select(driver.find_element(By.ID, "DisType"))
    dropdown.select_by_value("14")
    time.sleep(1)
    #第二個欄位選擇流感併發重症
    dropdown2 = Select(driver.find_element(By.ID, "DisId"))
    dropdown2.select_by_value("680")
    time.sleep(1)
    #按下搜尋的按鈕
    search_button = driver.find_element(By.XPATH, "//button[contains(text(), '搜尋')]")
    search_button.click()
    #等待指定標題顯示
    element = wait.until(EC.text_to_be_present_in_element((By.CLASS_NAME, "publication_title"), "影片 - 流感併發重症"))
    #抓取所需要的內容
    element2 = driver.find_elements(By.CSS_SELECTOR, ".col-md-4.col-xs-12")
    element2 = element2[::-1]
    for el in element2:
        a_element = el.find_element(By.TAG_NAME, "a")
        title = a_element.get_attribute("title")
        iframe_element = el.find_element(By.TAG_NAME, "iframe")
        href = iframe_element.get_attribute("src")
        p_element = el.find_element(By.XPATH, ".//p[contains(text(), '製作日期')]")
        date_text = p_element.text
        parts = date_text.split("：")
        original_date = parts[1]
        formatted_date = datetime.strptime(original_date, "%Y/%m/%d").date()
        if(formatted_date>last_date):
            cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'video-1')", (formatted_date ,title,href))
            print("標題: ",title)
            print("連結: ",href)
            print("時間: ",formatted_date)
            count +=1
            



    time.sleep(1)
    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='video-2';")
    last_date = cursor.fetchone()[0]
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("video-2 最新時間: ",last_date)
    #第一個欄位選擇為空氣或飛沫傳染
    dropdown = Select(driver.find_element(By.ID, "DisType"))
    dropdown.select_by_value("14")
    time.sleep(1)
    #第二個欄位選擇新型A型流感
    dropdown2 = Select(driver.find_element(By.ID, "DisId"))
    dropdown2.select_by_value("754")
    time.sleep(1)
    #按下搜尋的按鈕
    search_button = driver.find_element(By.XPATH, "//button[contains(text(), '搜尋')]")
    search_button.click()
    #等待指定標題顯示
    element = wait.until(EC.text_to_be_present_in_element((By.CLASS_NAME, "publication_title"), "影片 - 新型A型流感"))
    #抓取所需要的內容
    element2 = driver.find_elements(By.CSS_SELECTOR, ".col-md-4.col-xs-12")
    element2 = element2[::-1]
    for el in element2:
        a_element = el.find_element(By.TAG_NAME, "a")
        title = a_element.get_attribute("title")
        iframe_element = el.find_element(By.TAG_NAME, "iframe")
        href = iframe_element.get_attribute("src")
        p_element = el.find_element(By.XPATH, ".//p[contains(text(), '製作日期')]")
        date_text = p_element.text
        parts = date_text.split("：")
        original_date = parts[1]
        formatted_date = datetime.strptime(original_date, "%Y/%m/%d").date()
        if(formatted_date>last_date):
            cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'video-2')", (formatted_date ,title,href))
            print("標題: ",title)
            print("連結: ",href)
            print("時間: ",formatted_date)
            count +=1
            



    time.sleep(1)
    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='poster-1';")
    last_date = cursor.fetchone()[0]
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("poster-1 最新時間: ",last_date)
    poster_tab = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//li[@role='presentation']/a[contains(@href, '#poster')]")))
    poster_tab.click()
    #第一個欄位選擇為空氣或飛沫傳染
    dropdown = Select(driver.find_element(By.ID, "DisType"))
    dropdown.select_by_value("14")
    time.sleep(1)
    #第二個欄位選擇流感併發重症
    dropdown2 = Select(driver.find_element(By.ID, "DisId"))
    dropdown2.select_by_value("680")
    time.sleep(1)
    #按下搜尋的按鈕
    search_button = driver.find_element(By.XPATH, "//button[contains(text(), '搜尋')]")
    search_button.click()
    #等待指定標題顯示
    element = wait.until(EC.text_to_be_present_in_element((By.CLASS_NAME, "publication_title"), "海報 - 流感併發重症"))
    #抓取所需要的內容
    element2 = driver.find_elements(By.CSS_SELECTOR, ".col-md-4.col-xs-12")
    element2 = element2[::-1]
    for el in element2:
        a_element = el.find_element(By.TAG_NAME, "a")
        href = a_element.get_attribute("href")
        title_element = el.find_element(By.CSS_SELECTOR, ".m-b-0.t-o")
        title = title_element.text
        p_element = el.find_element(By.XPATH, ".//p[contains(text(), '製作日期')]")
        date_text = p_element.text
        parts = date_text.split("：")
        original_date = parts[1]
        formatted_date = datetime.strptime(original_date, "%Y/%m/%d").date()
        if(formatted_date>last_date):
            cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'poster-1')", (formatted_date ,title,href))
            print("標題: ",title)
            print("連結: ",href)
            print("時間: ",formatted_date)
            count +=1
            


    time.sleep(1)
    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='poster-2';")
    last_date = cursor.fetchone()[0]
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("poster-2 最新時間: ",last_date)
    poster_tab = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//li[@role='presentation']/a[contains(@href, '#poster')]")))
    poster_tab.click()
    #第一個欄位選擇為空氣或飛沫傳染
    dropdown = Select(driver.find_element(By.ID, "DisType"))
    dropdown.select_by_value("14")
    time.sleep(1)
    #第二個欄位選擇新型A型流感
    dropdown2 = Select(driver.find_element(By.ID, "DisId"))
    dropdown2.select_by_value("754")
    time.sleep(1)
    #按下搜尋的按鈕
    search_button = driver.find_element(By.XPATH, "//button[contains(text(), '搜尋')]")
    search_button.click()
    #等待指定標題顯示
    element = wait.until(EC.text_to_be_present_in_element((By.CLASS_NAME, "publication_title"), "海報 - 新型A型流感"))
    #抓取所需要的內容
    element2 = driver.find_elements(By.CSS_SELECTOR, ".col-md-4.col-xs-12")
    element2 = element2[::-1]
    for el in element2:
        a_element = el.find_element(By.TAG_NAME, "a")
        href = a_element.get_attribute("href")
        title_element = el.find_element(By.CSS_SELECTOR, ".m-b-0.t-o")
        title = title_element.text
        p_element = el.find_element(By.XPATH, ".//p[contains(text(), '製作日期')]")
        date_text = p_element.text
        parts = date_text.split("：")
        original_date = parts[1]
        formatted_date = datetime.strptime(original_date, "%Y/%m/%d").date()
        if(formatted_date>last_date):
            cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'poster-2')", (formatted_date ,title,href))
            print("標題: ",title)
            print("連結: ",href)
            print("時間: ",formatted_date)
            count +=1
            


    time.sleep(1)
    cursor.execute("SELECT MAX(`date`) FROM `news` WHERE `type` ='poster-3';")
    last_date = cursor.fetchone()[0]
    if last_date is None:
        last_date = datetime.strptime("2023-11-19", "%Y-%m-%d").date()
    print("poster-3 最新時間: ",last_date)
    poster_tab = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//li[@role='presentation']/a[contains(@href, '#poster')]")))
    poster_tab.click()
    #第一個欄位選擇為空氣或飛沫傳染
    dropdown = Select(driver.find_element(By.ID, "DisType"))
    dropdown.select_by_value("14")
    time.sleep(1)
    #第二個欄位選擇嚴重特殊傳染性肺炎
    dropdown2 = Select(driver.find_element(By.ID, "DisId"))
    dropdown2.select_by_value("872")
    time.sleep(1)
    #按下搜尋的按鈕
    search_button = driver.find_element(By.XPATH, "//button[contains(text(), '搜尋')]")
    search_button.click()
    #等待指定標題顯示
    element = wait.until(EC.text_to_be_present_in_element((By.CLASS_NAME, "publication_title"), "海報 - 嚴重特殊傳染性肺炎"))
    #抓取所需要的內容
    element2 = driver.find_elements(By.CSS_SELECTOR, ".col-md-4.col-xs-12")
    element2 = element2[::-1]
    for el in element2:
        a_element = el.find_element(By.TAG_NAME, "a")
        href = a_element.get_attribute("href")
        title_element = el.find_element(By.CSS_SELECTOR, ".m-b-0.t-o")
        title = title_element.text
        p_element = el.find_element(By.XPATH, ".//p[contains(text(), '製作日期')]")
        date_text = p_element.text
        parts = date_text.split("：")
        original_date = parts[1]
        formatted_date = datetime.strptime(original_date, "%Y/%m/%d").date()
        if(formatted_date>last_date):
            cursor.execute("INSERT INTO `news`(`date`, `title`, `url`, `type`) VALUES (%s,%s,%s,'poster-3')", (formatted_date ,title,href))
            print("標題: ",title)
            print("連結: ",href)
            print("時間: ",formatted_date)
            count +=1
        
    cursor.execute("UPDATE `ctr` SET `updateNews_ctr`=%s;", (count,))
    time.sleep(1)
    driver.close()
    cursor.close()
    connection.commit()
    connection.close()
    print("count",count)
    print("程式執行時間:",datetime.now())

    print("\n\n")

schedule.every().day.at("03:00").do(crawler)
while True:
    schedule.run_pending()
    time.sleep(1)



