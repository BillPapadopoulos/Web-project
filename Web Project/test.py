#install latest Chrome driver to your machine https://sites.google.com/chromium.org/driver/
#install Beautiful Soup 
#install selenium

#imports
from bs4 import BeautifulSoup
from selenium import webdriver
import time
import json 


#base product URL
URL = "https://e-katanalotis.gov.gr/product/"
min_id = 1000
max_id = 1003

#creates a list [min_id...max_id-1]
productids = range(min_id, max_id)

#final JSON
results = {}
results['fetch_date']=int(time.time())
results['data']=[]

#get product information
for productid in productids:
    print(productid)
    options = webdriver.ChromeOptions()
    options.add_argument('--headless')
    # executable_path param is where the Chrome driver is installed
    browser = webdriver.Chrome(options=options, executable_path='/Users/ako2/Downloads/chromedriver_mac64/chromedriver')
    browser.get(URL+str(productid))

    #get dates from price chart
    date_data = browser.execute_script('return Highcharts.charts[0].series[0].data.map(x => x.category)')
    #append year to date labels
    date_data = [s +'/2022' for s in date_data]

    #get prices from price chart
    price_data = browser.execute_script('return Highcharts.charts[0].series[0].data.map(x => x.y)')

    #find product name
    html = browser.page_source
    soup = BeautifulSoup(html, features="html5lib")

    #test html rendering
    #print(soup.prettify())

    pname = soup.find('p', attrs={'class':'product-name'}).text 
    browser.quit()

    #transform dates

    for i in range(len(date_data)-1):
        dparts = date_data[i].split("/")
        newd = '2022-'+dparts[1]+'-'+dparts[0]
        date_data[i]=newd
        
    #create a result object
    result = {}
    result['id']=productid
    result['name']=pname
    result['prices']=[]
    for i in range(len(date_data)-1):
        result['prices'].append({'date':date_data[i], 'price':price_data[i]})
    
    #append it to the list
    results['data'].append(result)

print('Done')