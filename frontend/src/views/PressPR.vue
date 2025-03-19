<template>
    <div class="press-pr">
      <div class="hero-section">
        <h1>Press & PR</h1>
      </div>
      <div class="content">
        <p>If you would like to reach out to us regarding any press, PR enquiries, or content collaboration opportunities, please send an email over to <a href="mailto:pr@mochipals.com">pr@mochipals.com</a> and a member of the MochiPals team will be in touch.</p>
        <p>We look forward to hearing from you!</p>
      </div>
    </div>
  </template>
  
  <style scoped>
  .press-pr {
    padding-top: 120px; /* 避免被 Header 覆蓋 */
    padding-bottom: 80px;
    background-color: #f9f9f9;
  }
  
  .hero-section {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
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
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
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
  
  .content a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
  }
  
  .content a:hover {
    text-decoration: underline;
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
  </style>