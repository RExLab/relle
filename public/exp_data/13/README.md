# Lab Package

About
------
Lab Package for the **[Remote Labs Learning Enviroment](http://relle.ufsc.br)**.

Lab Page
------
The pages are supported in portuguese language and English. Edit the archives `pt.html` and `en.html`.

- Name the experiment.
Example:

```
<h1>Lab Name</h1>
```

- Video Streaming. Use external IP, supported format MPEG.
Example:

```
<img src='http://rexlab.ufsc.br:8072' width="100%"/>
```

- Controls for manipulate experiment. For manipulate the experimento use JavaScript archive with name `exp_script.js`. Include controls in archives HTML.

- Results...

- Diagrams are included in the HTML archives in the tag `<img src="">`.

- Reports are optionals. For use reports include in archives HTML:

```
<div id="report"></div>
```

Reports Pages
---------------
The pages are supported in portuguese language and English. Edit the archives `report_pt.blade.php` and `report_en.blade.php`.

- Snapshot for remote experiment. Include the server image in a HTML tag.
Example:

```
<img src = "http://rexlab.ufsc.br:8073/motion/snapshot.jpg" width = "320" height = "240">
```
- Illustrative Image and results. Include the diagram of experiment or other result.
Example:

```
<img src = "http://relle.ufsc.br/exp_data/1/img/diagrama.png" width = "320" height = "240">
```

In case of chart. Convert and send imagem using the function `toDataURL()` using JavaScript and send by method POST in archive `exp_script.js`.
Example:

```
function report(id) {
    url = document.getElementById("canvas").toDataURL();	//Convert Canvas element
    $.ajax({
        type: "POST",
        url: "http://relle.ufsc.br/labs/" + id + "/report/",
        data: {dados: url},									//Send data in a vector
        success: function (pdf) {
            var win = window.open("http://relle.ufsc.br/labs/" + id + "/report", '_blank');
            console.log("Report created.");
        }
    });
}

```
In archive `report`.
```
<img src = "<?php $troca = $rpijson['dados']; echo $troca; ?> " width = "320" height = "240">
```

For vector the elements. Send by method POST a JSON response. Results basead in the JSON response.
Example: 

```
echo ($rpijson['vectorname'][position]);
```

Contact
--------

Remote Experimentation Laboratory

- http://rexlab.ufsc.br

Remote Labs Learning Enviroment

- http://relle.ufsc.br

- rexlab@contato.ufsc.br
