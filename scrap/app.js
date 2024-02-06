const express = require('express');
const axios = require('axios');
const cheerio = require('cheerio');

const app = express();
const PORT = 3000;

app.use(express.json());

// Enable CORS for all routes
app.use((req, res, next) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
  res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
  next();
});

// Scrape route
app.post('/scrape', async (req, res) => {
  try {
    const { articleUrls } = req.body;

    const results = [];

    for (const url of articleUrls) {
      const { data } = await axios.get(url);
      const $ = cheerio.load(data);

      const title = $('.article__title a').text().trim();
      const lead = $('.article__lead').text().trim();
      const category = $('.article__subtitle').text().trim();
      const date = $('.article__date').text().trim();

      const article = {
        title,
        lead,
        category,
        date,
        url,
      };

      results.push(article);
    }

    res.json(results);
  } catch (error) {
    console.error('Error scraping articles:', error.message);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});