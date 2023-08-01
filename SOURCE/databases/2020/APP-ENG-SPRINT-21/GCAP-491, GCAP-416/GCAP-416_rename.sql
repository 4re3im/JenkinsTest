-- Rename tables in prepartion for DROP

-- Back up listed tables to be altered below

-- Run script
ALTER TABLE tngdb.CupGoAccessCodes RENAME tngdb.CupGoAccessCodesForRemoval;

ALTER TABLE tngdb.CupGoTabAccess RENAME tngdb.CupGoTabAccessForRemoval;
ALTER TABLE tngdb.CupGoTabAccessUpdated RENAME tngdb.CupGoTabAccessUpdatedForRemoval;
ALTER TABLE tngdb.CupGoTabAccessUpdates RENAME tngdb.CupGoTabAccessUpdatesForRemoval;
ALTER TABLE tngdb.CupGoTabAccessTemp RENAME tngdb.CupGoTabAccessTempForRemoval;
ALTER TABLE tngdb.CupGoTabAccessRollover RENAME tngdb.CupGoTabAccessRolloverForRemoval;

ALTER TABLE tngdb.CupGoUserSubscription RENAME tngdb.CupGoUserSubscriptionForRemoval;
ALTER TABLE tngdb.CupGoUserSubscriptionRollover RENAME tngdb.CupGoUserSubscriptionRolloverForRemoval;
ALTER TABLE tngdb.CupGoUserSubscriptionHMProvision RENAME tngdb.CupGoUserSubscriptionHMProvisionForRemoval;

ALTER TABLE tngdb.CupContentOrder RENAME tngdb.CupContentOrderForRemoval;
ALTER TABLE tngdb.CupContentVistaOrderRecord RENAME tngdb.CupContentVistaOrderRecordForRemoval;

ALTER TABLE tngdb.CupContentTitleDownloadableFileOrderRecord RENAME tngdb.CupContentTitleDownloadableFileOrderRecordForRemoval;

ALTER TABLE tngdb.CupContentGoAccessCodeEmailTemplate RENAME tngdb.CupContentGoAccessCodeEmailTemplateForRemoval;
ALTER TABLE tngdb.CupGoAccessCodeBulkActivation RENAME tngdb.CupGoAccessCodeBulkActivationForRemoval;
ALTER TABLE tngdb.CupContentGoAccessCode RENAME tngdb.CupContentGoAccessCodeForRemoval;
ALTER TABLE tngdb.CupGoAccessCodesBundle RENAME tngdb.CupGoAccessCodesBundleForRemoval;
ALTER TABLE tngdb.CupGoNotifications RENAME tngdb.CupGoNotificationsForRemoval;

-- To be retained now but should still be deleted
-- ALTER TABLE tngdb.CupGoAccessCodeBatch RENAME tngdb.CupGoAccessCodeBatchForRemoval;
-- ALTER TABLE tngdb.CupGoSubscription RENAME tngdb.CupGoSubscriptionForRemoval;
-- ALTER TABLE tngdb.CupGoSubscriptionTabs RENAME tngdb.CupGoSubscriptionTabsForRemoval;
-- ALTER TABLE tngdb.CupGoSubscriptionAvailability RENAME tngdb.CupGoSubscriptionAvailabilityForRemoval;
-- ALTER TABLE tngdb.CupGoQuizTitles RENAME tngdb.CupGoQuizTitlesForRemoval;
-- ALTER TABLE tngdb.CupGoCheckQuestions RENAME tngdb.CupGoCheckQuestionsForRemoval;
-- ALTER TABLE tngdb.CupGoSubscriptionQuiz RENAME tngdb.CupGoSubscriptionQuizForRemoval;

