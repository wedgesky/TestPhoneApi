Questa API REST prende in gestione un file csv (presente sotto la cartella doc), contenente una serie di numeri SMS, e restituisce un file JSON con una lista
di numeri SMS validi, non validi (indicando il motivo) ed errati. Tale controllo viene definito in base alla lunghezza del numero SMS. I numeri corretti hanno lunghezza
pari 11, quelli da correggere sono numerici e hanno lunghezza diversa da 11 (indicando anche il motivo), infine quelli errati sono non numerici
Per poter gestire tale risultato è necessario utilizzare un software che gestisca le chiamate HTTP, in particolar modo 'POST'. Per tale finalità si può
utilizzare il software Postman. Richiamando in 'POST' l'url definito dal 'nome sito'/test/records ed inviando come parametro 'file' un file csv, formattato come
quello definito sotto la cartella doc. Il file restituito è in formato JSON ed è formattato come un csv, con separatore di colonna ','.
Richiamando dal browser 'nome sito'/new si accede ad un form per testare la correttezza di un numero SMS.
Nel progetto, sotto la cartella SQL, c'è il dump del db