Questa API REST prende in gestione un file csv (presente sotto la cartella doc), contenente una serie di numeri SMS, e restituisce un file JSON con una lista
di numeri SMS validi, non validi (indicando il motivo) ed errati. Tale controllo viene definito in base alla lunghezza del numero SMS.
Per poter gestire tale risultato è necessario utilizzare un software che gestisca le chiamate HTTP, in particolar modo 'POST'. Per tale finalità si può
utilizzare il software Postman. Richiamando in 'POST' l'url definito dal 'nome sito'/test/records ed inviando come parametro 'file' un file csv, formattato come
quello definito sotto la cartella doc.
Nel progetto, sotto la cartella SQL, c'è il dump del db