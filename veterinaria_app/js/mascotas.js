document.getElementById("registroMascotaForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var mascotaId = "MAS-" + Math.random().toString(36).substr(2, 9); 
    console.log("ID generado:", mascotaId);  
    document.getElementById("mascota_id").value = mascotaId;
    document.getElementById("mensajeId").style.display = "block"; 
    document.getElementById("idMascotaDisplay").textContent = mascotaId; 

    this.submit();
});

    document.getElementById("tipo").addEventListener("change", function() {
        const selectedType = this.value;
        const breedInput = document.getElementById("breedInput");

        if (selectedType === "perro") {
            breedInput.style.display = "block"; 
        } else {
            breedInput.style.display = "none"; 
            document.getElementById("raza").value = ""; 
        }
    });