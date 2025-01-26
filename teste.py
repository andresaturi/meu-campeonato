import sys
import json
from random import randint

def result(teams):
    teams[0]['goals'] = randint(0, 8)
    teams[1]['goals'] = randint(0, 8)
    if teams[0]['goals'] == teams[1]['goals']:
       extra_time(teams)
    return teams


def extra_time(teams):
    teams[0]['extra_time'] = randint(0, 2)
    teams[1]['extra_time'] = randint(0, 2) 
    if teams[0]['extra_time'] == teams[1]['extra_time']:
        penalties(teams)



def penalties(teams):
    team1_goals = 0
    team2_goals = 0
    victory = 5
    
    while True:
        team1_penalty = randint(0, 1) 
        team2_penalty = randint(0, 1)  
        
        team1_goals += team1_penalty
        team2_goals += team2_penalty        
      
        if team1_goals >= victory and team2_goals >= victory:
            if team1_goals == team2_goals:               
                continue        
       
        if (team1_goals == victory and team2_goals < victory) or (team2_goals == victory and team1_goals < victory):
            teams[0]['penalties'], teams[1]['penalties'] = team1_goals, team2_goals           
            break        
      
        if team1_goals == victory and team2_goals == victory:
            continue  
        


if __name__ == "__main__":    
    game = json.loads(sys.argv[1])
    print(json.dumps(result(game)))
