window.addEventListener("DOMContentLoaded", function () {
   document.querySelector("#fetchQuotesBtn").addEventListener("click", function () {

      // Get values from drop-downs
      const topicDropdown = document.querySelector("#topicSelection");
      const selectedTopic = topicDropdown.options[topicDropdown.selectedIndex].value;
      const countDropdown = document.querySelector("#countSelection");
      const selectedCount = countDropdown.options[countDropdown.selectedIndex].value;
   
      // Get and display quotes
      fetchQuotes(selectedTopic, selectedCount);	   
   });
});

function fetchQuotes(topic, count) {
   let xhr = new XMLHttpRequest();
   xhr.addEventListener("load", responseReceivedHandler);
   xhr.responseType = "json";
   let queryString = "topic="+topic+"&count="+count;
   xhr.open("GET", "https://wp.zybooks.com/quotes.php?" + queryString);
   xhr.send();

   let html = "<ol>";
   for (let c = 1; c <= count; c++) {
      html += `<li>Quote ${c} - Anonymous</li>`;
   }
   html += "</ol>";

   document.querySelector("#quotes").innerHTML = html;
}

function responseReceivedHandler(){
    if(this.response.error !== undefined){
        let quotes = document.getElementById("quotes");
        quotes.innerHTML = this.response.error;
    }
    else{
        let html = "<ol>";
        for (let c = 0; c < this.response.length; c++) {
           html += `<li>${this.response[c].quote} - ${this.response[c].source}</li>`;
        }
        html += "</ol>";

       document.querySelector("#quotes").innerHTML = html;

    }

}