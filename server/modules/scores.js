module.exports = function () {

    /**
     *
     * @param data:
     *  - event
     *  - member
     *  - judge
     *  - contest
     *  - stage
     *  - criterion
     *  - score:
     *      - criterion - member score for criterion
     *      - stage - stage coefficient
     *      - contest - contest coefficient
     *      - result - result coefficient
     */
    var update = function (data) {

        data.stage    = data.contest + '-' + data.stage;
        data.criterion = data.stage + '-' + data.criterion;

        return Mongo.connect(config.Mongo.url).then(function (db) {

            var collection = db.collection('event' + data.event);

            data.member = parseInt(data.member);
            data.judge = parseInt(data.judge);

            return collection.findOne({
                member: data.member,
                'scores.judge': data.judge
                },
                {'scores.judge.$': 1, 'total': 1})
                    .then(function (result) {
                        if (!result) {

                            return collection.findOne({member: data.member}).then(
                                function(result) {

                                    var payload = {
                                        judge: data.judge,
                                        criterions: {[data.criterion]: parseInt(data.score.criterion)},
                                        stages: {[data.stage]: data.score.stage * data.score.criterion},
                                        contests: {[data.contest]: data.score.contest * data.score.criterion},
                                        result: data.score.result * data.score.criterion
                                    };

                                    var total = {
                                        criterions: {[data.criterion]: parseInt(data.score.criterion)},
                                        stages: {[data.stage]: data.score.stage * data.score.criterion},
                                        contests: {[data.contest]: data.score.contest * data.score.criterion},
                                        result: data.score.result * data.score.criterion
                                    };

                                    if (result) {

                                        result.total.criterions[data.criterion] = result.total.criterions[data.criterion] || 0;
                                        result.total.stages[data.stage] = result.total.stages[data.stage] || 0;
                                        result.total.contests[data.contest] = result.total.contests[data.contest] || 0;
                                        result.total.result = result.total.result || 0;

                                        result.total.criterions[data.criterion] += total.criterions[data.criterion];
                                        result.total.stages[data.stage] += total.stages[data.stage];
                                        result.total.contests[data.contest] += total.contests[data.contest];
                                        result.total.result += total.result;

                                        return collection.updateOne({member: data.member}, {$push: {scores: payload}, $set: {total: result.total}}, function (err, result) {
                                            db.close();
                                        });

                                    } else {
                                        return collection.insertOne({member: data.member, scores: [payload], total: total}).then(function(){db.close()});
                                    }

                                });

                        } else {

                            var scores = result.scores[0],
                                old = scores.criterions[data.criterion] || 0;
                                scores.stages[data.stage] = scores.stages[data.stage] || 0;
                                scores.contests[data.contest] = scores.contests[data.contest] || 0;
                                scores.result = scores.result || 0;

                            result.total.criterions[data.criterion] = result.total.criterions[data.criterion] || 0;
                            result.total.stages[data.stage] = result.total.stages[data.stage] || 0;
                            result.total.contests[data.contest] = result.total.contests[data.contest] || 0;
                            result.total.result  = result.total.result || 0;

                            scores.criterions[data.criterion] = parseInt(data.score.criterion);
                            scores.stages[data.stage]        += (data.score.criterion - old) * data.score.stage;
                            scores.contests[data.contest]    += (data.score.criterion - old) * data.score.contest;
                            scores.result                    += (data.score.criterion - old) * data.score.result;

                            result.total.criterions[data.criterion] += data.score.criterion - old;
                            result.total.stages[data.stage] += (data.score.criterion - old) * data.score.stage;
                            result.total.contests[data.contest] += (data.score.criterion - old) * data.score.contest;
                            result.total.result += (data.score.criterion - old) * data.score.result;

                            var payload = {
                                $set: {'scores.$': scores, total: result.total}
                            };

                            return collection.updateOne({
                                member: data.member,
                                'scores.judge': data.judge
                            }, payload).then(function (err, result) {db.close();})

                        }

            });

        });

    };



    return {
        update: update
    };

}();
