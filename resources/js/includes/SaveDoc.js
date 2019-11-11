class HtmlToDoc {
     constructor(html, form, caption) {
          this.rawHtml = html,
               this.name = caption
          this.form = form
     }

     getWord() {
          for (var key in this.form) {
               this.parse(key, this.form[key])
          }
          this.table()
          var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
               "xmlns:w='urn:schemas-microsoft-com:office:word' " +
               "xmlns='http://www.w3.org/TR/REC-html40'>" +
               "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
          var footer = "</body></html>";
          var sourceHTML = header + this.rawHtml + footer;
          var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
          var fileDownload = document.createElement("a");
          document.body.appendChild(fileDownload);
          fileDownload.href = source;
          fileDownload.download = `${this.name}.doc`;
          fileDownload.click();
          document.body.removeChild(fileDownload);
     }
     parse(needl, value) {
          this.rawHtml = this.rawHtml.replace(new RegExp(`#${needl}#`, 'g'), `${value}`)
     }

     table() {
          let table = "";
          let index = 1;
          for (var key in this.form.items) {
               table += `<tr><td>${index}</td><td>${key}</td><td>${Object.keys(this.form.items[key]).length}</td><td>`
               this.form.items[key].forEach(element => {
                    table += `${element.reg_num_item}<br>`
               });
               table += "</td><td>"
               this.form.items[key].forEach(element => {
                    table += `${element.ser_num_item}<br>`
               });
               table += "</td></tr>"
               index++
          }
          this.parse("table", table)

     }
}
export default {
     getWord(rawHtml, form, name) {
          return new HtmlToDoc(rawHtml, form, name).getWord()
     }
}
