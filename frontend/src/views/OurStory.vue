<template>
    <div class="our-story">
      <div class="hero-section">
        <h1>Our Story</h1>
        <p>Born in Malaysia. Loved worldwide.</p>
      </div>
      <div class="content">
        <p>For a quarter of a century, we have shared the joy of MochiPals toys with people of all ages, across the globe. Over this time, our unmistakable characters have gained the affection of millions – and center stage in many of the most prestigious stores across 77 countries.</p>
        <p>Our designers play until something magical and unexpected happens – and a new character is born! We source beautiful materials that are noticeably softer, subtler and long-lasting.</p>
      </div>
    </div>
  </template>
  
  <style scoped>
  .our-story {
    padding-top: 120px; /* 避免被 Header 覆蓋 */
    padding-bottom: 80px;
    background-color: #f9f9f9;
  }
  
  .hero-section {
    background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    padding: 60px 20px;
    text-align: center;
    color: white;
  }
  
  .hero-section h1 {
    font-size: 48px;
    font-weight: bold;
    margin-bottom: 20px;
    animation: fadeInDown 1s ease;
  }
  
  .hero-section p {
    font-size: 24px;
    animation: fadeInUp 1s ease;
  }
  
  .content {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1.5s ease;
  }
  
  .content p {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  </style>