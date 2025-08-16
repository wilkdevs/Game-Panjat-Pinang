
const CONSISTENCY_DURATION = parseInt(server_settings["consistencyDuration"]);

function getHourlySeed() {
  const now = new Date();
  const hoursSinceEpoch = Math.floor(now.getTime() / (1000 * 60 * CONSISTENCY_DURATION));
  return hoursSinceEpoch.toString();
}

function generateSeedRandomGameHour(unique) {
  const seed = unique + getHourlySeed();
  const rng = new Math.seedrandom(seed);
  const now = new Date();

  const offsetStartMinutes = Math.floor(rng() * (60 + 20)) - 20; // -20 to +60
  const startTime = new Date(now.getTime() + offsetStartMinutes * 60 * 1000);

  const offsetEndMinutes = Math.floor(rng() * (180 - 30 + 1)) + 30;
  const endTime = new Date(startTime.getTime() + offsetEndMinutes * 60 * 1000);

  const formatTime = (d) => d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');

  return `${formatTime(startTime)} WIB - ${formatTime(endTime)} WIB`;
}

function generateSeedRandomPercent(unique) {
  const seed = unique + getHourlySeed();
  const rng = new Math.seedrandom(seed);

  const percent = Math.floor(rng() * (97 - 15 + 1)) + 15;

  return percent;
}

function generateSeedRandomPattern(unique) {
    const seed = unique + getHourlySeed() + "pattern";
    const rng = new Math.seedrandom(seed);

    // 1 in 30 chance to return empty array
    if (Math.floor(rng() * 30) === 0) {
        return [];
    }

    const totalRows = 3;
    const pattern = [];

    for (let i = 0; i < totalRows; i++) {
        const isAuto = rng() > 0.5;
        const method = isAuto ? "Auto" : "Manual";
        const number = Math.floor(rng() * 100);
        const key = `${method} ${number}`;

        const results = [];
        let canBeSuccess = true;

        for (let j = 0; j < 3; j++) {
            if (canBeSuccess && rng() > 0.4) {
                results.push("success");
            } else {
                results.push("fail");
                canBeSuccess = false;
            }
        }

        pattern.push({ key, results });
    }

    return pattern;
}

