<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Switch Status (Pie Chart)</h6>
                                    <div class="dropdown no-arrow">
                            
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="card shadow mb-4" style="height: 250px;">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Switch Status</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                    <?php
                                            // Fetch switch status counts from ping_results table
                                            $statuses = ['Up', 'Down'];

                                            foreach ($statuses as $status) {
                                                $sql = "SELECT COUNT(DISTINCT ip_address) as status_count FROM ping_results WHERE status = :status AND ip_address IS NOT NULL";
                                                $query = $conn->prepare($sql);
                                                $query->bindParam(':status', $status, PDO::PARAM_STR);
                                                $query->execute();
                                                $result = $query->fetch();

                                                // Display switch status count
                                                echo '<div>';
                                                echo '<p style="font-size: 22px; font-weight: bold; color: ' . ($status == 'Up' ? '#1cc88a' : 'red') . ';">' . $status . ' switches: ' . $result['status_count'] . '</p>';
                                                echo '</div>';

                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        </div>
