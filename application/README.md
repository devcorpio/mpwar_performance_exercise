# Exercise
Your company receives a new project that needs some work done. The client has a blog that allows authors to sign-up and write articles, but it needs some new features that your company needs to implement:
- They want to start using Ansistrano to deploy the blog.
- Use [Bootstrap](https://getbootstrap.com/) to give a basic layout to the blog. Remember to optimize the load of css and js files.
- Authors should be able to upload their profile picture when creating their account. Upload these images to Amazon S3.
- The home page should show the top 5 articles, according to the visits received. This ranking has two different views: global ranking; and currently logged user articles ranking. Use Redis to create this ranking.

Your client also asks you to improve the overall performance of the page. They expect to grow in traffic, and their servers are almost at full capacity already. Change everything that is needed to make the blog work with multiple servers behind a load balancer:
- Sessions should be saved in a distributed way.
- Database queries results should be stored in Redis.
- Create a CloudFront distribution that serves the static content files like images, css or js.
- Use HTTP Cache to let browsers, proxies and gateway servers like CloudFront cache your dynamic pages.

## Remember
- Apply all the knowledge that we've learnt on the Performance classes.
- Use Apache AB / JMeter before and after each change to see how your application behaves.
- Install BlackFire so you can profile the requests to your server.

## What do I need to deliver?
You need to deliver the source code of the application, together with a document explaining the process of building the required features.
Think that this document is like your diary, where you write your daily work, which troubles you found and how you fixed them. This will be useful in the future.

In this document you need to include screen shots of Apache AB / Apache JMeter tests before and after every change. Also include the public DNS name for your Load Balancer, so I can test how your application works.
Blackfire screen shots would be nice, but if you can link to public profiles on the Blackfire website, that'd be great.
