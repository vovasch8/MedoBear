<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>https://medo-bear.com</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>https://medo-bear.com/delivery</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
    <url>
        <loc>https://medo-bear.com/about-us</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
    <url>
        <loc>https://medo-bear.com/contacts</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
    <url>
        <loc>https://medo-bear.com/login</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
    <url>
        <loc>https://medo-bear.com/register</loc>
        <lastmod>2024-06-07T11:27:54+00:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
    @foreach($categories as $key => $time)
        <url>
            <loc>https://medo-bear.com/categories/{{$key}}</loc>
            <lastmod>{{$time->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach
    @foreach($products as $key => $time)
        <url>
            <loc>https://medo-bear.com/product/{{$key}}</loc>
            <lastmod>{{$time->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach
</urlset>

