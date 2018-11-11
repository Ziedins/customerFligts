const passangers =  document.getElementById('passangers'),
    trips = document.getElementById('trips');

if(passangers || trips)
{
    passangers.addEventListener('click', (e) => {
        if(e.target.className === 'btn btn-primary delete-passanger') {
            const id = e.target.getAttribute('data-id');
            if(confirm('Do you want to delete this passanger?')) {
                fetch('/delete/passanger/'+id, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
    trips.addEventListener('click', (e) => {
        if(e.target.className === 'btn btn-primary delete-trip') {
            const id = e.target.getAttribute('data-id');
            if(confirm('Do you want to delete this trip?')) {
                fetch('/delete/trip/'+id, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}