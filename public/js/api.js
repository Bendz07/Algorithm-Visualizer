const API = {
    runAlgorithm(array, type, target = null) {
        const formData = new FormData();
        formData.append('array', JSON.stringify(array));
        formData.append('type', type);
        if (target !== null) {
            formData.append('target', target);
        }
        
        return fetch('index.php?action=run', {
            method: 'POST',
            body: formData
        }).then(r => r.json());
    },

    fetchSteps(sessionId) {
        return fetch(`index.php?action=getSteps&session_id=${sessionId}`)
            .then(r => r.json());
    }
};