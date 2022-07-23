import logo from './logo.svg';
import './App.css';
import React, { useState, useEffect } from 'react';


function App() {

  const [messages, setMessages] = useState([]);

  useEffect(() => {
   fetch(`http://127.0.0.1:8080/message`)
  .then(res => res.json())
  .then(data => setMessages(data))

  },[]);
  
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        {console.log(messages)}
        <div className="d_flex" >
          {messages.data?.map((message) => (
            <div className="message_cl" key={message.id}>{message.body}</div>
        ))}
        </div>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
        </a>
      </header>
    </div>
  );
}

export default App;
