var userKundennummer = undefined;
var ergebniss = undefined;
execute();

function execute(parse = 'jsonParse.php') {
    let parseData = getParse(parse).then(data => data);
    let artikel = 'Kein Artikel gefunden<br>';
    let auftraege = 'Kein Auftraege gefunden<br>';

    parseData.then(parseData => {
        if(Array.isArray(parseData)) {
            parseData.forEach((item)=>{
                userDataBlock(item);
            });  
        } 
        else {
            Object.keys(parseData).forEach((key)=>{
                if(key == 'data'|| key == 'artikel' || key == 'auftraege') {
                
                    if(userKundennummer === undefined) {
                        userKundennummer = parseData[key].kundennummer;
                        userDataBlock(parseData[key]);
                    }
                    else if(ergebniss == 'user_rechnungen') {
                        let rechnungKey = undefined;
                        let rechnungKeyZwei = undefined;
                        let rechnung = undefined;
                        
                        if(parseData[key].length > 1) {
                            rechnungKey = getRandomInt(0, parseData[key].length - 1);
                            rechnung = parseData[key][rechnungKey];
                            
                            document.getElementById('rechnung1').innerHTML = 'BelegNr: ' + rechnung.belegnr + '<br> Auftrag: ' + rechnung.auftrag + '<br> Kundennummer: ' + rechnung.kundennummer + '<br> Name: ' + rechnung.name + '<br> Datum: ' + rechnung.datum + '<br> Mahnwesen: ' + rechnung.mahnwesen;
                            
                            do {
                                rechnungKeyZwei = getRandomInt(0, parseData[key].length - 1)
                            } 
                            while (rechnungKey == rechnungKeyZwei);
                            rechnung = parseData[key][rechnungKeyZwei];
                            document.getElementById('rechnung2').innerHTML = 'BelegNr: ' + rechnung.belegnr + '<br> Auftrag: ' + rechnung.auftrag + '<br> Kundennummer: ' + rechnung.kundennummer + '<br> Name: ' + rechnung.name + '<br> Datum: ' + rechnung.datum + '<br> Mahnwesen: ' + rechnung.mahnwesen;
                        }
                        else if(parseData[key].length = 1) {
                            rechnung = parseData[key][0];
                            document.getElementById('rechnung1').innerHTML = 'BelegNr: ' + rechnung.belegnr + '<br> Auftrag: ' + rechnung.auftrag + '<br> Kundennummer: ' + rechnung.kundennummer + '<br> Name: ' + rechnung.name + '<br> Datum: ' + rechnung.datum + '<br> Mahnwesen: ' + rechnung.mahnwesen;
                            document.getElementById('rechnung2').innerHTML = 'kein Rechnungen';
                        }
                        else {
                            document.getElementById('rechnung1').innerHTML = 'kein Rechnungen';
                            document.getElementById('rechnung2').innerHTML = 'kein Rechnungen';
                        }
                    }
                    else if(ergebniss == 'suchen') {
                        
                        let anzahl = 0;
                        let i = 0;

                        if(key == 'artikel') {
                            
                            if(parseData[key] != 'empty' && parseData[key].data != undefined && parseData[key].data.length) {
                                
                                anzahl = parseData[key].data.length;
                                i = 1;
                                artikel = '<center><b>Es ist ' + anzahl + ' Aartikel gefunden</b></center><br>';
                                
                                parseData[key].data.forEach((item)=>{
                                    artikel = artikel + i + ')' + '<br>&#160;&#160;art: ' + item.art + '<br>&#160;&#160;bearbeiter: ' + item.bearbeiter + '<br>&#160;&#160;datum: ' + item.datum + '<br>&#160;&#160;name: ' + item.name + '<br>&#160;&#160;status: ' + item.status + '<br>';
                                    i++;
                                });
                            }
                        }
                        if(key == 'auftraege') {
                            if(parseData[key] != 'empty' && parseData[key].data  != undefined && parseData[key].data.length) {

                                anzahl = parseData[key].data.length;
                                i = 1;
                                auftraege = '<center><b>Es ist ' + parseData[key].data.length + ' Auftraege gefunden</b></center><br>';
                                parseData[key].data.forEach((item)=>{
                                    auftraege = auftraege + i + ')' + '<br>&#160;&#160;name_de: ' + item.name_de + '<br>&#160;&#160;id: ' + item.id + '<br>&#160;&#160;hersteller: ' + item.hersteller + '<br>&#160;&#160;nummer: ' + item.nummer + '<br>&#160;&#160;typ: ' + item.typ + '<br>&#160;&#160;logdatei: ' + item.logdatei + '<br>';
                                });
                            }
                        }
                        document.getElementById('artikelAuftraege').innerHTML = artikel + '<hr>' + auftraege;
                    }
                }
            });  
        }
    });
}

function userDataBlock(parseData) {
    document.getElementById('userDataBlock').innerHTML = 'Hallo ' + parseData.name + '<hr>Anschrift<br>Strasse: ' + parseData.strasse + '<br>Ort: ' + parseData.ort + '<br>Plz: ' + parseData.plz + '<br>Telefon: ' + parseData.telefon;
    document.getElementById('angrif').innerHTML = 'Auftrag für den Kunden ' + parseData.name + ' mit der Kundennummer ' + parseData.kundennummer;
    document.getElementById('user_rechnungen').value = userKundennummer;
    document.getElementById('user_rechnungen').innerHTML = 'Drücken Sie hier für die Suche nach zwei beliebigen Artikeln(Rechnungen) über die API für den Kunden Testkunde mit der Kundennummer: ' + parseData.kundennummer;
}

function ergebnisse(a) {
    ergebniss = a;
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

async function getParse(parse) {
    return await fetch(parse).then(result => result.json());
}