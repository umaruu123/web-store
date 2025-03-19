<template>
    <div class="why-us">
      <div class="hero-section">
        <h1>Why Choose MochiPals?</h1>
      </div>
      <div class="content">
        <div class="features">
          <div class="feature">
            <h2>Fast Delivery</h2>
            <p>Enjoy quick and reliable delivery services with MochiPals.</p>
          </div>
          <div class="feature">
            <h2>Free Shipping</h2>
            <p>We offer free shipping on all orders over $50.</p>
          </div>
          <div class="feature">
            <h2>Best Quality</h2>
            <p>Our products are made with the finest materials for long-lasting enjoyment.</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .why-us {
    padding-top: 120px; /* 避免被 Header 覆蓋 */
    padding-bottom: 80px;
    background-color: #fff;
  }
  
  .hero-section {
    background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
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
  
  .content {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    animation: fadeIn 1.5s ease;
  }
  
  .features {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
  }
  
  .feature {
    flex: 1;
    min-width: 280px;
    padding: 30px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    background-color: #f9f9f9;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: fadeInUp 1s ease;
  }
  
  .feature:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }
  
  .feature h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #0056b3;
  }
  
  .feature p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
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