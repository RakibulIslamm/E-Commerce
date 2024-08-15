# Missing activities
[ ] Enable size and color options
[ ] PayPal
[ ] Registration Process
    [ ] mandadory
    [ ] mandadory with confirmation
[ ] Product Stock Display
    [ ] text only
    [ ] text + quantity  
    [ ] do not display
[ ] b2b puro automatic mandadory with confirmation
[ ] Offer Display
   [ ] cut price 
   [ ] not visualize
[ ] rest api 
  [] add Basic Authentication rest

[ ] change valute in eur

Moduli ecommerce availables
[ ] New Arrivals
[ ] On Sale
[ ] Featured
[ ] Best Sellers
[ ] View Packages by Pallet
[ ] View Packages by Layer
[ ] Sale by Packages


[ ] shipping data
[ ] limitation for cap




## API REST (see document pdf in italian):
{
    "Codice": "OK",
    "n_ordini": 1,
    "ordini": [
        {
            "id": 1,
            "user_id": 1,
            "nominativo": "fabrizio",
            "promotion_id": 0,
            "ragione_sociale": "fabrizio",
            "indirizzo": "test",
            "cap": "90145",
            "citta": "Palermo",
            "provincia": "Palermo",
            "email": "fabrizio.corpora@gmail.com",
            "telefono": "3281867883",
            "stato": -1,
            "pagato": 0,
            "totale_netto": null,
            "totale_iva": null,
            "spese_spedizione": "5.00",
            "nominativo_spedizione": "fabrizio",
            "ragione_sociale_spedizione": null,
            "indirizzo_spedizione": "test",
            "cap_spedizione": "90145",
            "citta_spedizione": "Palermo",
            "provincia_spedizione": "Palermo",
            "spedizione": "standard",
            "note": null,
            "corriere": null,
            "nuovi": 0,
            "created_at": "2024-08-15T01:03:45.000000Z",
            "updated_at": "2024-08-15T01:03:45.000000Z",
            "articoli": [
                {
                    "id": 1,
                    "order_id": 1,
                    "product_id": 1,
                    "imponibile": "20.00",
                    "ivato": "22.00",
                    "qta": 2,
                    "created_at": "2024-08-15T01:03:45.000000Z",
                    "updated_at": "2024-08-15T01:03:45.000000Z"
                }
            ]
        }
    ]
}


/elenco_ordini
Viene reso l’elenco degli ordini con possibilità di filtro.

Documentazione Rest AsterSoftware, pagina 3 di 5

• id,n_ordine,data_ordine,promo,nominativo,ragione_sociale,indirizzo,cap,
citta,provincia,email, telefono,stato,pagamento, totale_netto,
totale_iva,promo_netto,promo_iva, spese_spedizione, nominativo_spedizione,
ragione_sociale_spedizione,indirizzo_spedizione,
cap_spedizione,citta_spedizione,provincia_spedizione, pec,sdi,note
• Per ogni ordine un array articoli
◦ articolo[]=>id|qta|imponibile|ivato
i prezzi citati sono quelli pagati effettivamente dal cliente (in caso ad esempio di sconti
promozionali sull’articolo)